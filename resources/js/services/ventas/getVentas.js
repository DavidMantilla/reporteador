import axios from "axios";
import config from "../../config/api";


async function getVentas(url) {
    try {
        const response = await axios.get(`${config.OdataUrl}ventas${url}`);
        return response;
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
}

async function CargarchartVentas() {
    let empresa = JSON.parse(document.getElementById("idempresa").value);

    let ventasEmpresa = `?$filter=Id_Empresa eq ${empresa.Id_Empresa}&$orderby=FechaDoc asc`;
    console.log(ventasEmpresa);

    let response = await getVentas(ventasEmpresa);
    const ctx = document.getElementById("myChart");

    if (response.status == 200) {
        const data = response.data.value;
        let chartData = [];
        let chartLabel = [];
        let FechaDoc = null;
        let facturaTotal = 0;
        data.forEach((element) => {
            console.log(element.FechaDoc.split("T")[0]);
            
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

        new Chart(ctx, {
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
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
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
            });
        }
    }
}

async function CargarTotal() {


    if (document.getElementById("Numcuentas")) {
        let empresa = JSON.parse(document.getElementById("idempresa").value);
        let cargarMeta = `?$filter=(Id_Empresa eq ${empresa.Id_Empresa})&&$count=true`;
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

CargarTotal();
Cargarmetas();
CargarchartVentas();
