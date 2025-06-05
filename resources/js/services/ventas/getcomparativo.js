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


async function getApiVentas(url) {
    try {
        let uri=`${config.apiUrl}ventas/reportes/${url}`
         console.log(uri);
        let auth=localStorage.getItem('authToken');
        const response = await axios.get(decodeURI(uri),{headers:{

            Authorization:"bearer "+auth
        }});
        return response;
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}



async function getventasComparativo(event) {
    event.preventDefault();
   
   sucursal = event.target["sucursal"].value;
    let response= await getApiVentas(`comparativo?sucursal=${sucursal}`);
    let jsonData = response.data;
  
   comparativo(jsonData);
}


 function  comparativo(data) {
    let anio=0;
       
 
     try {
        if (table) {
            table.clear().rows.add(data).draw(); // Refresca con nuevos datos sin destruir la instancia
        } else {
            table = new DataTable("#compAniostable", {
                data: data,
                columns: [
                    { data: "Sucursal", title: "Sucursal" },
                    {
                        data: "Anio",
                        title: "Año",
                    },
                    { data: "Total_ventas",render:(data, type, row)=>{
                        let valor = new Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency: "MXN", // Puedes cambiar a USD, EUR, etc.
                            });
                        return  valor.format(data);
                    }, title: "Total Ventas" },
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
        let response= await getApiVentas('comparativo');
        let jsonData = response.data;
        comparativo(jsonData);
    })();
}


let formComparativo = document.getElementById("formComparativo");
if (formComparativo != null) {
    formComparativo.addEventListener("submit", getventasComparativo);
}

