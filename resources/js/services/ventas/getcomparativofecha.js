import axios from "axios";
import config from "../../config/api";
import DataTable from "datatables.net-dt";
let table = null;
let sucursal = "";
let chartcomp = null;

async function getVentas(url) {
    try {
        console.log(`${config.OdataUrl}ventas?$expand=sucursales${url}`);

        const response = await axios.get(
            `${config.OdataUrl}ventas?$expand=sucursales${url}`
        );
        return response;
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}
async function getApiVentas(url) {
    try {
        let uri = `${config.apiUrl}ventas/reportes/${url}`;
        console.log(uri);
        let auth = localStorage.getItem("authToken");
        const response = await axios.get(decodeURI(uri), {
            headers: {
                Authorization: "bearer " + auth,
            },
        });
        return response;
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}

async function CargarchartVentas(chartData, chartLabel) {
    console.log(chartData);
    console.log(chartLabel);

    let comparativoChart = document.getElementById("comparativoChart");

    if (chartcomp == null) {
        chartcomp = new Chart(comparativoChart, {
            type: "line",
            data: {
                labels: chartLabel,
                datasets: chartData,
            },
            options: {
                scales: {
                    x: {
                        title: { display: true, text: "Meses" },
                    },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: "Total Ventas" },
                        ticks: {
                                callback: function (value) {
                                    // Formatear las etiquetas del eje Y como pesos colombianos
                                    return `$${value.toLocaleString()} `;
                                },
                            },
                    },
                },

                responsive: true,
                plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    // Formatear el valor como pesos colombianos
                                    return `$${context.raw.toLocaleString()}`;
                                },
                            },
                        },
                    },
            },
        });
    } else {
        chartcomp.data.datasets = chartData;
        chartcomp.update();
    }
}

async function getventasComparativo(event) {
    event.preventDefault();

    sucursal = event.target["filsucursal"].value;

    let empresa = JSON.parse(document.getElementById("idempresa").value);
    let periodo = `&$filter=(Id_Empresa eq ${empresa.Id_Empresa})${
        sucursal !== "" ? ` and Id_Sucursal eq ${sucursal}` : ""
    }`;

    // let response = await getVentas(periodo);
    // let jsonData = response.data["value"];
    // ;

    let response = await getApiVentas("compafecha");
    let jsonData = response.data;

    comparativo(jsonData);
}

function comparativo(data) {
    let res = data.reduce((acumulador, venta) => {
        let anio = venta.Anio;
        let mes = venta.Mes;

        if (!acumulador[anio]) {
            acumulador[anio] = {
                meses: Array(12).fill(0),
                Numero_Transacciones: 0,
                sucursal: "",
                Total_Ventas: 0,
            };
        }
        let valor= Intl.NumberFormat();
        acumulador[anio].meses[mes - 1] = venta.Total_ventas;
        acumulador[anio].Total_Ventas+= parseInt(venta.Total_ventas);
        // Si deseas usar los siguientes campos, descomenta y ajusta según estructura:
        acumulador[anio].Numero_Transacciones += 1;

        return acumulador;
    }, {});

    console.log(res);

    const resultado = Object.entries(res).map(([anio, datos]) => {
        console.log(anio); // Aquí sí puedes usarlo
        //let valor= Intl.NumberFormat();
       //datos.Total_Ventas= valor.format(datos.Total_Ventas);
        return {
            Anio: anio,
            ...datos,
        };
    });

    

    let anioAct = "";

    let chartData = [];
    resultado.map((item) => {
        console.log(item);
        
        chartData.push({
            label: "Total Ventas año " + item.Anio,
            data: item.meses,
            borderWidth: 2,
        });
    });

    let meses = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
    ];
    CargarchartVentas(chartData, meses);

    try {
        if (table) {
            table.clear().rows.add(resultado).draw(); // Refresca con nuevos datos sin destruir la instancia
        } else {
            table = new DataTable("#compFechaTable", {
                data: resultado,
                columns: [
                 
                    {
                        data: "Anio", title: "Año"
                    },
                    { data: "Total_Ventas",render:function(data, type, row){
                        let valor=new Intl.NumberFormat("es-MX", {
                             style: "currency",
                             currency: "MXN", // Puedes cambiar a USD, EUR, etc.
                             });   
                             
                             return valor.format(data);
                        }, title: "Total Ventas" },
                    {
                        data: "meses",
                        render: function (data, type, row) {
                            let meses = [
                                "Enero",
                                "Febrero",
                                "Marzo",
                                "Abril",
                                "Mayo",
                                "Junio",
                                "Julio",
                                "Agosto",
                                "Septiembre",
                                "Octubre",
                                "Noviembre",
                                "Diciembre",
                            ];

                            let mesesData = data.map((mes, index) => {
                                if (mes !== 0) {
                                    let valor=new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN", // Puedes cambiar a USD, EUR, etc.
                });
                                    return `<b>${meses[index]}</b>: ${valor.format(mes)}`;
                                } else {
                                    return "";
                                }
                            });
                            return mesesData
                                .filter((element) => element !== "")
                                .join("<br> ");
                        },
                        title: "meses",
                    },
                    {
                        data: "Numero_Transacciones",
                        title: "Numero Transacciones",
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

let exportExcel = async () => {
    let url = `${config.apiUrl}ventas/excel/compafecha?sucursal=${sucursal}`;
    window.location.href = url;
};

let exportPdf = async () => {
    let url = `${config.apiUrl}ventas/pdf/compafecha?sucursal=${sucursal}`;
    window.location.href = url;
};

let ventasExcel = document.getElementById("CompafechaExcel");
if (ventasExcel) {
    ventasExcel.addEventListener("click", () => {
        exportExcel();
    });
}

let ventasPdf = document.getElementById("CompafechaPdf");
if (ventasPdf) {
    ventasPdf.addEventListener("click", () => {
        exportPdf();
    });
}

let formComparativo = document.getElementById("formComparativofecha");
if (formComparativo != null) {
    formComparativo.addEventListener("submit",(evt)=>{ getventasComparativo(evt)});
}
