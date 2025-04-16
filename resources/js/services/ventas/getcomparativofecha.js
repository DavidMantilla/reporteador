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
                        title: { display: true, text: "Año" },
                    },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: "Total Ventas" },
                    },
                },

                responsive: true,
            },
        });
    }else{

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

    let response = await getVentas(periodo);
    let jsonData = response.data["value"];
    comparativo(jsonData);
}

function comparativo(data) {
    let res = data.reduce((acumulador, venta) => {
        const anio = new Date(venta.FechaDoc).getFullYear();
        const mes = new Date(venta.FechaDoc).getMonth() + 1; // Mes en formato 1-12
        if (!acumulador[anio]) {
            acumulador[anio] = {
                meses: Array(12).fill(0),
                Numero_Transacciones: 0,
                sucursal: "",
                Total_Ventas: 0,
            };
        }

        acumulador[anio].meses[mes - 1] = parseFloat(
            (venta.Importe - venta.Descuento + venta.Impuesto) *
                venta.TipoCambio
        ).toFixed(2);
        acumulador[anio].Sucursal = venta.sucursales.Sucursal;
        acumulador[anio].Total_Ventas +=
            (venta.Importe - venta.Descuento + venta.Impuesto) *
            venta.TipoCambio;
        acumulador[anio].Numero_Transacciones += 1;
        return acumulador;
    }, {});

    const resultado = Object.entries(res).map(([anio, datos]) => ({
        meses: datos.meses,

        // Asegúrate de que esto sea un array de números
        Numero_Transacciones: datos.Numero_Transacciones,
        Anio: anio,
        Total_Ventas: datos.Total_Ventas,
        Sucursal: datos.Sucursal,
    }));

    let anioAct = "";

    let chartData = [];
    resultado.map((item) => {
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
                    { data: "Sucursal", title: "Sucursal" },
                    {
                        data: "Anio",
                        title: "Año",
                    },
                    { data: "Total_Ventas", title: "Total Ventas" },
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
                                    return `<b>${meses[index]}</b>: ${mes}`;
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

if (document.getElementById("compFechaTable") != null) {
    (async () => {
        let response = await getVentas("");

        let jsonData = response.data["value"];
        comparativo(jsonData);
    })();
}

let formComparativo = document.getElementById("formComparativofecha");
if (formComparativo != null) {
    formComparativo.addEventListener("submit", getventasComparativo);
}
