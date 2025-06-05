import axios from "axios";
import config from "../../config/api";
import DataTable from "datatables.net-dt";
let table = null;

let anio = "";
let sucursal = "";

async function getVentas(url) {
    try {
        console.log(
            encodeURI(`${config.OdataUrl}ventas?$expand=sucursales${url}`)
        );

        const response = await axios.get(
            encodeURI(`${config.OdataUrl}ventas?$expand=sucursales${url}`)
        );
        return response;
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}
function inicializeventasTable(jsonData) {
    try {
        if (table) {
            table.clear().rows.add(jsonData).draw(); // Refresca con nuevos datos sin destruir la instancia
        } else {
            table = new DataTable("#Aniotable", {
                data: jsonData,
                columns: [
                    {
                        data: "FechaDoc",
                        render: function (data, type, row) {
                            data = new Date(data);

                            return data.toISOString().split("T")[0];
                        },
                        title: "Fecha",
                    },
                    {
                        data: "sucursal",
                        render: function (data, type, row) {
                            return row.sucursales.Sucursal;
                        },
                        title: "sucursal",
                    },
                    { data: "Cliente", title: "código cliente" },
                    { data: "NombreCliente", title: "Nombre Cliente" },
                    {
                        data: "Importe",
                        render: (data, type, row) => {
                            let valor = new Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency: row.Moneda.replace(
                                    "MN",
                                    "MXN"
                                ).replace("mx", "MXN"), // Puedes cambiar a USD, EUR, etc.
                            });

                            return valor.format(data);
                        },
                        title: "Importe",
                    },
                    { data: "Moneda", title: "Moneda" },
                    {
                        data: "Impuesto",
                        render: (data, type, row) => {
                            let valor = new Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency: row.Moneda.replace(
                                    "MN",
                                    "MXN"
                                ).replace("mx", "MXN"), // Puedes cambiar a USD, EUR, etc.
                            });

                            return valor.format(data);
                        },
                        title: "Impuesto",
                    },
                    {
                        data: "Total",
                        render: function (data, type, row) {
                            // Calcular el total restando el descuento del importe y sumando el impuesto
                            let valor = new Intl.NumberFormat("es-MX", {
                                style: "currency",
                                currency: row.Moneda.replace(
                                    "MN",
                                    "MXN"
                                ).replace("mx", "MXN"), // Puedes cambiar a USD, EUR, etc.
                            });
                            return valor.format(
                                row.Importe - row.Descuento + row.Impuesto
                            );
                        },
                        title: "Total",
                    },
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

async function getventasAnio(data) {


    anio = data["anio"];
    sucursal =data["sucursal"] ;

    let empresa = JSON.parse(document.getElementById("idempresa").value);

    let periodo = `&$filter=(Id_Empresa eq ${empresa.Id_Empresa})`;

    if (sucursal != "") {
        periodo += `${
            sucursal !== "" ? ` and Id_Sucursal eq ${sucursal}` : ""
        }`;
    }
    periodo += `${anio != "" ? ` and year(FechaDoc) eq ${anio}` : ""}`;

    let response = await getVentas(periodo);
    let jsonData = response.data["value"];

    inicializeventasTable(jsonData);
}

let exportExcel = async () => {
    let url = `${config.apiUrl}ventas/excel/anio?year=${anio}&sucursal=${sucursal}`;
    window.location.href = url;
};

let exportPdf = async () => {
    let url = encodeURI(
        `${config.apiUrl}ventas/pdf/anio?year=${anio}&sucursal=${sucursal}`
    );
    console.log(url);
    window.location.href = url;
};

let ventasExcel = document.getElementById("AnioExcel");
if (ventasExcel) {
    ventasExcel.addEventListener("click", () => {
        exportExcel();
    });
}

let ventasPdf = document.getElementById("AnioPdf");
if (ventasPdf) {
    ventasPdf.addEventListener("click", () => {
        exportPdf();
    });
}

let formMes = document.getElementById("formAnio");
if (formMes != null) {
    
    let hoy = new Date();
    formMes["anio"].value= hoy.getFullYear();
    getventasAnio({'anio':hoy.getFullYear(),"sucursal":""});
    formMes.addEventListener("submit", (event) => {
        event.preventDefault();
        anio = event.target["anio"].value;
        sucursal = event.target["sucursal"].value;
        getventasAnio({ anio, sucursal });
    });
}
