import axios from "axios";
import config from "../../config/api";

async function maxProd(jsondata) {
    try {
     
       
            let total=0;
            let api = `${config.apiUrl}partVenta`;
            if (jsondata) {
                const inicio = jsondata.finicio.value;
                const final = jsondata.ffin.value;
                const SlSucursal = jsondata.SlSucursal.value;
                api += `?inicio= ${inicio} && final= ${final}`;
            }
          
            
            const response = await axios.get( encodeURI(api));

            if (response.status == 200) {
                let data = response.data;
                let prod = document.getElementById("productList");

                prod.innerHTML = "";
                data.forEach((element) => {
                    let li = document.createElement("li");
                    li.className = "list";
                    li.innerHTML = `<b>${element.Articulo.toUpperCase()}</b> &nbsp; <br>${element.Descripcion.toUpperCase()} <br>  <b>$${element.precio.toUpperCase()}</b>`;
                    prod.append(li);
                    total+=parseFloat(element.precio);
                });

           console.log(total);
                
                  document.getElementById("totalproductos").innerText=`$${new Intl.NumberFormat().format(total).toString()}`;
            }
        
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}


    
export default maxProd;

    

