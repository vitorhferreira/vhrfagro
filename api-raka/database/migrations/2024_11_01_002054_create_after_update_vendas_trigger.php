<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAfterUpdateVendasTrigger extends Migration
{
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER after_update_vendas AFTER UPDATE ON vendas FOR EACH ROW
            BEGIN
                DECLARE valor_compra DECIMAL(10,2);
                DECLARE peso_comprado DECIMAL(10,2);
                DECLARE total_gastos DECIMAL(10,2);
                DECLARE total_gastos_lote DECIMAL(10,2);
                DECLARE quantidade_total_lote INT;

                SELECT valor_individual * NEW.quantidade_vendida,
                       peso * NEW.quantidade_vendida
                INTO valor_compra, peso_comprado
                FROM lotes
                WHERE id = NEW.lote_id;

                SELECT quantidade INTO quantidade_total_lote
                FROM lotes
                WHERE id = NEW.lote_id;

                SELECT IFNULL(SUM(valor), 0) INTO total_gastos_lote
                FROM gastovets
                WHERE lote = (SELECT numero_lote FROM lotes WHERE id = NEW.lote_id);

                SET total_gastos = (total_gastos_lote / (quantidade_total_lote + NEW.quantidade_vendida)) * NEW.quantidade_vendida;

                UPDATE relatorio
                SET
                    valor_venda = (SELECT SUM(valor_unitario * quantidade_vendida) FROM vendas WHERE lote_id = NEW.lote_id),
                    peso_vendido = (SELECT SUM(peso_medio_venda * quantidade_vendida) FROM vendas WHERE lote_id = NEW.lote_id),
                    quantidade_vendida = (SELECT SUM(quantidade_vendida) FROM vendas WHERE lote_id = NEW.lote_id),
                    quantidade_comprada = NEW.quantidade_vendida,
                    valor_compra = valor_compra,
                    total_gastos = total_gastos,
                    lucro = valor_venda - valor_compra - total_gastos,
                    numero_lote = NEW.numero_lote
                WHERE lote_id = NEW.lote_id;
            END
        ");
    }

    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_update_vendas");
    }
}

