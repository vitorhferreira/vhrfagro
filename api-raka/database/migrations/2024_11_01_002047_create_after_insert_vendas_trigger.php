<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAfterInsertVendasTrigger extends Migration
{
    public function up()
    {
        DB::unprepared("
            CREATE TRIGGER after_insert_vendas AFTER INSERT ON vendas FOR EACH ROW
            BEGIN
                DECLARE valor_compra DECIMAL(10,2);
                DECLARE peso_comprado DECIMAL(10,2);
                DECLARE total_gastos DECIMAL(10,2);
                DECLARE total_gastos_registrados DECIMAL(10,2);
                DECLARE total_vacinas INT;
                DECLARE quantidade_total_lote INT;

                SELECT valor_individual * NEW.quantidade_vendida,
                       peso * NEW.quantidade_vendida
                INTO valor_compra, peso_comprado
                FROM lotes
                WHERE id = NEW.lote_id;

                SELECT quantidade INTO quantidade_total_lote
                FROM lotes
                WHERE id = NEW.lote_id;

                SELECT IFNULL(SUM(total_gastos), 0) INTO total_gastos_registrados
                FROM relatorio
                WHERE lote_id = NEW.lote_id;

                SELECT (IFNULL(SUM(valor), 0) - total_gastos_registrados) / quantidade_total_lote * NEW.quantidade_vendida
                INTO total_gastos
                FROM gastovets
                WHERE lote = (SELECT numero_lote FROM lotes WHERE id = NEW.lote_id);

                SELECT COUNT(*)
                INTO total_vacinas
                FROM vacinas
                WHERE numero_lote = (SELECT numero_lote FROM lotes WHERE id = NEW.lote_id);

                INSERT INTO relatorio (lote_id, id_venda, valor_compra, peso_comprado, quantidade_comprada, valor_venda, peso_vendido, quantidade_vendida, total_gastos, total_vacinas, lucro, numero_lote)
                VALUES (
                    NEW.lote_id,
                    NEW.id,
                    valor_compra,
                    peso_comprado,
                    NEW.quantidade_vendida,
                    NEW.valor_unitario * NEW.quantidade_vendida,
                    NEW.peso_medio_venda * NEW.quantidade_vendida,
                    NEW.quantidade_vendida,
                    total_gastos,
                    total_vacinas,
                    (NEW.valor_unitario * NEW.quantidade_vendida) - valor_compra - total_gastos,
                    NEW.numero_lote
                )
                ON DUPLICATE KEY UPDATE
                    valor_venda = valor_venda + (NEW.valor_unitario * NEW.quantidade_vendida),
                    peso_vendido = peso_vendido + (NEW.peso_medio_venda * NEW.quantidade_vendida),
                    quantidade_vendida = quantidade_vendida + NEW.quantidade_vendida,
                    total_gastos = total_gastos + (total_gastos - total_gastos_registrados),
                    lucro = (valor_venda) - valor_compra - total_gastos;
            END
        ");
    }

    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_insert_vendas");
    }
}

