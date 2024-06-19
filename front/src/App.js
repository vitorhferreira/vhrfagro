import { Button, Cascader, Typography } from "antd";
import api from './api'
import "antd/dist/antd.css"
import React, { useEffect, useState } from "react";

function App() {
  const [linhas, setLinhas] = useState([]);
  useEffect(()=>{

  },[])

  const getFilters =  async () =>{
    try {
      const response = await api.get('/departamento/cascader')
      setLinhas(response.data);
    } catch (error) {
      console.error('Error searching:', error);
      setLinhas([]);
    }
  }
  const get =  async () =>{
    try {
      const response = await api.get('/vacinas')
      setLinhas(response.data);
    } catch (error) {
      console.error('Error searching:', error);
      setLinhas([]);
    }
  }

  return (
    <>
     <Typography>teste</Typography>
     <Button onClick={()=>get()}>teste</Button>
     <Cascader options={[{
      value: "Teste",
      label: "Teste"
     }]} />
    </>
  );
}

export default App;
