import axios from "axios";
import config from "../../config/api";
import maxprod from "../partventas/maxprod";
let ventasChart = "";
async function getVentas(url) {
    try {
        console.log(encodeURI(`${config.OdataUrl}ventas${url}`));
        const response = await axios.get(`${config.OdataUrl}ventas${url}`);
        return response;
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}

async function CargarchartVentas(jsondata) {
    let inicio;
    let final;
    let empresa = JSON.parse(document.getElementById("idempresa").value);

    let ventasEmpresa = `?$filter=Id_Empresa eq ${empresa.Id_Empresa}`;

    if (jsondata) {
        inicio = jsondata.finicio.value;
        final = jsondata.ffin.value;
        SlSucursal = jsondata.SlSucursal.value;
        ventasEmpresa += ` and (FechaDoc ge ${inicio} and FechaDoc le ${final}) `;
    }
    ventasEmpresa += `&$orderby=FechaDoc asc`;

    let response = await getVentas(ventasEmpresa);
    const ctx = document.getElementById("myChart");

    if (response.status == 200) {
        const data = response.data.value;
        let chartData = [];
        let chartLabel = [];
        let FechaDoc = null;
        let facturaTotal = 0;
        console.log(data);

        data.forEach((element) => {
            if (FechaDoc !== element.FechaDoc) {
                if (facturaTotal > 0) {
                    chartLabel.push(element.FechaDoc.split("T")[0]);
                    chartData.push(facturaTotal);
                }
                FechaDoc = element.FechaDoc;
                facturaTotal = element.Facturado;
            } else {
                facturaTotal += element.Facturado;
            }
        });

        // Agregar el último dato después de salir del bucle
        if (facturaTotal > 0) {
            chartLabel.push(FechaDoc.split("T")[0]);
            chartData.push(facturaTotal);
        }

        if (!ventasChart) {
            ventasChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: chartLabel,
                    datasets: [
                        {
                            label: "Total de ventas",
                            data: chartData,
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
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
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    // Formatear las etiquetas del eje Y como pesos colombianos
                                    return `$${value.toLocaleString()} `;
                                },
                            },
                        },
                    },
                },
            });
        } else {
            ventasChart.clear();
            ventasChart.data.labels = chartLabel; // Corregido
            ventasChart.data.datasets = [
                { label: "Total de ventas", data: chartData, borderWidth: 1 },
            ];
            ventasChart.update();
        }
    }
}

async function Cargarmetas() {
    if (document.getElementById("diaria") != null) {
        const empresa = JSON.parse(document.getElementById("idempresa").value);
        const diaria = document.getElementById("diaria");
        const mensual = document.getElementById("mensual");
        const anual = document.getElementById("anual");
        const valAño = empresa.meta;
        const valMes = valAño / 12;
        const dia = valMes / 30;

        let cargarMeta = `?$filter=Id_Empresa eq ${empresa.Id_Empresa}`;
        let response = await getVentas(cargarMeta);
        if (response.status == 200) {
            let year = null;
            let facturaTotal = 0;
            let actual = 2020;
            const data = response.data.value;
            data.forEach((element) => {
                year = new Date(element.FechaDoc).getFullYear();
                if (year == actual) {
                    facturaTotal += element.Facturado;
                }
            });

            new Chart(diaria, {
                type: "doughnut",
                data: {
                    datasets: [
                        {
                            data: [facturaTotal / 365, dia],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
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
            new Chart(mensual, {
                type: "doughnut",
                data: {
                    datasets: [
                        {
                            data: [facturaTotal / 12, valMes],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
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

            new Chart(anual, {
                type: "doughnut",
                data: {
                    datasets: [
                        {
                            data: [facturaTotal, valAño],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
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
        }
    }
}

async function CargarTotal(jsondata) {
    if (document.getElementById("Numcuentas")) {
        let empresa = JSON.parse(document.getElementById("idempresa").value);
        let cargarMeta = `?$filter=(Id_Empresa eq ${empresa.Id_Empresa})`;
        let inicio;
        let final;

        if (jsondata) {
            inicio = jsondata.finicio.value;
            final = jsondata.ffin.value;
            SlSucursal = jsondata.SlSucursal.value;
            cargarMeta += ` and (FechaDoc ge ${inicio} and FechaDoc le ${final}) `;
        }
        cargarMeta += `&&$count=true`;

        console.log("Total: " + cargarMeta);

        let response = await getVentas(cargarMeta);
        let data = response.data;
        document.getElementById("Numcuentas").innerText = data["@count"];
        document.getElementById("importe").innerText = " $0";

        let total = 0;
        data["value"].forEach((element) => {
            total += element.Importe;
        });
        document.getElementById("importe").innerText = `$ ${total.toFixed(2)}`;
    }
}
// finicio
// ffin
// SlSucursal

async function horas(jsondata) {
    let inicio;
    let final;
    let query = `${config.apiUrl}ventas/reportes/hora`;
    console.log(query);

    if (jsondata) {
        inicio = jsondata.finicio.value;
        final = jsondata.ffin.value;
        SlSucursal = jsondata.SlSucursal.value;
        query += `?initialDate=${inicio}&&finalDate=${final}`;
    }

    try {
        const response = await axios.get(query, { withCredentials: true });
        const data = response.data;
        let value=0;
         let valor=new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN", // Puedes cambiar a USD, EUR, etc.
                });
        if (data) {
            let produc = document.getElementById("horas");
            produc.style.listStyle = "none";
            produc.style.fontWeight = "400";
            data.forEach((element) => {
                let hora = element.Hora - 12;
                let horastr = "";
                if (hora > 0) {
                    horastr = "" + hora + ":00 a.m.";
                } else {
                    horastr = "" + element.Hora + ":00 p.m.";
                }
               


               

                let texto =
                    horastr +
                    " <span style='font-weight:bold'> " +
                     valor.format(element.Promedio_Ventas)+
                    "</span>";
                
                let li = document.createElement("li");
                li.innerHTML = texto;
                li.style.display="flex";
                li.style.justifyContent="space-between";
                produc.appendChild(li);
                value+= element.Promedio_Ventas;
                
            });

            let total=document.getElementById("totalHora");
            total.innerText=valor.format(parseFloat(value))
          
            
        }

    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}

let search = document.getElementById("search");

if (search) {
    search.addEventListener("submit", (event) => {
        // Specify event type (e.g., "click")
        event.preventDefault();

        let finicio = document.getElementById("finicio");
        let ffin = document.getElementById("ffin");
        let SlSucursal = document.getElementById("SlSucursal");

        CargarTotal({ finicio, ffin, SlSucursal });
        Cargarmetas({ finicio, ffin, SlSucursal });
        CargarchartVentas({ finicio, ffin, SlSucursal });
        horas({ finicio, ffin, SlSucursal });
        maxprod({ finicio, ffin, SlSucursal });
    });
}

if (document.getElementById("finicio")) {
    const initialDate = document.getElementById("finicio");
    const finalDate = document.getElementById("ffin");
    const Suc = document.getElementById("SlSucursal");

    const hoy = new Date();
    const anioActual = hoy.getFullYear();
    const mesActual = hoy.getMonth();

    let inicio = new Date(anioActual, mesActual, 1); // Primer día del mes
    let fin = new Date(anioActual, mesActual + 1, 0); // Último día del mes

    initialDate.value = inicio.toISOString().split("T")[0]; // Formato YYYY-MM-DD
    finalDate.value = fin.toISOString().split("T")[0];

    CargarTotal({ finicio: initialDate, ffin: finalDate, SlSucursal: Suc });
    Cargarmetas({ finicio: initialDate, ffin: finalDate, SlSucursal: Suc });
    CargarchartVentas({
        finicio: initialDate,
        ffin: finalDate,
        SlSucursal: Suc,
    });
    maxprod({ finicio: initialDate, ffin: finalDate, SlSucursal: Suc });
    horas({ finicio: initialDate, ffin: finalDate, SlSucursal: Suc });
}
