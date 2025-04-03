import axios from "axios";
import config from "../../config/api";
import DataTable from "datatables.net-dt";
let table = null;
let sucursal = "";

async function getVentas(url) {
    try {
        console.log(`${config.OdataUrl}ventas?$expand=sucursales${url}`);

        const response = await axios.get(`${config.OdataUrl}ventas?$expand=sucursales${url}`);
        return response;
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}




async function getventasComparativo(event) {
    event.preventDefault();
   
   sucursal = event.target["sucursal"].value;

    let empresa = JSON.parse(document.getElementById("idempresa").value);
    let periodo = `&$filter=(Id_Empresa eq ${empresa.Id_Empresa})${
        sucursal !== "" ? `and  Id_Sucursal  eq ${sucursal}` : ""}`;

    let response = await getVentas(periodo);
    let jsonData = response.data["value"];
    comparativo(jsonData);
}


 function  comparativo(data) {
    let anio=0;
   
    
    let res=data.reduce((acumulador, venta) => {
        const anio = new Date(venta.FechaDoc).getFullYear();
        if (!acumulador[anio]) {
          acumulador[anio] = { Total_Ventas: 0, Numero_Transacciones: 0 ,sucursal:""};
        }
       

        acumulador[anio].Total_Ventas += (venta.Importe-venta.Descuento+venta.Impuesto)*venta.TipoCambio;
        acumulador[anio].Sucursal = venta.sucursales.Sucursal	;
        acumulador[anio].Numero_Transacciones += 1;
        return acumulador;
      }, {});
    
      const resultado = Object.entries(res).map(([anio, datos]) => ({
        Anio: anio,
        Total_Ventas: datos.Total_Ventas.toFixed(2), // Redondear a dos decimales
        Numero_Transacciones: datos.Numero_Transacciones,
        Sucursal:datos.Sucursal
      }));
  
  
     try {
        if (table) {
            table.clear().rows.add(resultado).draw(); // Refresca con nuevos datos sin destruir la instancia
        } else {
            table = new DataTable("#compAniostable", {
                data: resultado,
                columns: [
                    { data: "Sucursal", title: "Sucursal" },
                    {
                        data: "Anio",
                        title: "Año",
                    },
                    { data: "Total_Ventas", title: "Total Ventas" },
                   { data: "Numero_Transacciones", title: "Numero Transacciones" },
                ],
                searchable: true, // Activa la búsqueda en la tabla
                sortable: true, // Activa el ordenamiento
                perPage: 5, // Cantidad de elementos por página
            });
        }
    } catch (error) {
        console.error("Error al inicializar DataTable:", error);
    }

    
    
}

let exportExcel = async () => {
   
    let url = `${config.apiUrl}ventas/excel/comparativo?sucursal=${sucursal}`;
     window.location.href = url;
};

let exportPdf = async () => {
   
    let url = `${config.apiUrl}ventas/pdf/comparativo?sucursal=${sucursal}`;
     window.location.href = url;
};

let ventasExcel = document.getElementById("ComparativoExcel");
if (ventasExcel) {
    ventasExcel.addEventListener("click", () => {
        exportExcel();
    });
}

let ventasPdf = document.getElementById("ComparativoPdf");
if (ventasPdf) {
    ventasPdf.addEventListener("click", () => {
        exportPdf();
    });
}



if (document.getElementById("compAniostable") != null) {
    (async () => {
        let response = await getVentas("");
      
        let jsonData = response.data["value"];
        comparativo(jsonData);
    })();
}


let formComparativo = document.getElementById("formComparativo");
if (formComparativo != null) {
    formComparativo.addEventListener("submit", getventasComparativo);
}

