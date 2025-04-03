import axios from "axios";
import config from "../../config/api";

async function maxProd() {
    
    
    try {
        
        
        const response = await axios.get(`${config.apiUrl}partVenta`);
        
        if(response.status==200){

        let data=response.data;
           let prod= document.getElementById("productList");
        
           prod.innerHTML="";
        data.forEach((element)=>{

        
           let li=document.createElement("li");
           li.className="list";
           li.innerHTML=`<b>${element.Articulo.toUpperCase()}</b> &nbsp; <br>${element.Descripcion.toUpperCase()} <br>  <b>$${element.precio.toUpperCase()}</b>`;
           prod.append(li);
        })
        }
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}

if(document.getElementById("productList")){

    maxProd();
}