import axios from "axios";

let EmpresaUrl = "";

let id = window.location.pathname.split("/");
id = id[id.length - 1];

let licenciamiento = `http://127.0.0.1:8000/odata/sucursales?$expand=licenciamientos&$filter=Id_Empresa eq ${id}`;

let total = 0;
let pagina = 0;
let tamanopagina = 6;
let getSucursales = async (page, pageSize) => {
    try {
        if (licenciamiento != "") {
            let url=`${licenciamiento}&$top=${pageSize}&$skip=${
                page * pageSize
            }&$count=true`;
            console.log(url);
            
            const response = await axios.get(url);
            return response.data;
        }
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
};

const ShowSucursales=(response)=>{
    let listSucursales = document.getElementById("listSucursales");
    listSucursales.innerHTML="";
    response.forEach((element) => {
        let container = document.createElement("div");
        container.className = "col-md-4";
        container.innerHTML = ` <div class="card" style="min-height:500px">
                                <div class="card-body">
                                    <div class="row">

                                    <h4 style="font-weight:bold;text-align:left">${element.Sucursal}</h4>
                                     <p> <span style="color:#EE5D31">SUID:</span>  &nbsp;${element.SUID} </p> 
                                     <p> <span style="color:#EE5D31">Estado:</span>  &nbsp;${element.Estado} </p> 
                                        <h5 style="font-weight:bold;text-align:left">licencias</h5>
                                        <ul id="licencia" style="padding:10px;list-style:none;">
                                        ${element.licenciamientos.map((licencia) => `
                                            <li style="margin-bottom: 20px; border-bottom: 1px solid #444;">
                                                <div class="d-flex">
                                                    ${licencia.Id_Unico}
                                                    <div><span class="badge badge-secondary" style="background: #EE5D31; height: 20px;">${licencia.Estado}</span>
                                                    <button class="btn"> <i class="fa-regular fa-pen-to-square"></i></button>
                                                    </div>

                                                </div>
                                                <span class="fa-regular fa-calendar"></span>
                                                <span style="font-size: 12px;">${licencia.FechaInicial} - ${licencia.FechaFinal}</span>
                                                
                                            </li>
                                        `).join('')}
                                        </ul>
                                        </div>
                                </div>`;

        listSucursales.append(container);
    });
}

const cargarData = async () => {
    let response = await getSucursales(0,tamanopagina);
    
    let total = response["@count"];
    let pagina = Math.ceil(total / tamanopagina);
   
    
    ShowSucursales(response.value)

    let pag = document.getElementById("pag-sucursales");
            pag.innerHTML = "";
            let previous = document.createElement("li");
            previous.className = "page-item";
            previous.innerHTML = ` <button class="page-link" >
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>`;
            previous.addEventListener("click", () => {
                getSucursales(0, tamanopagina).then((response) => {
                    ShowSucursales(response.value);
                });
            });
            pag.append(previous);
    
            for (let index = 0; index < pagina; index++) {
                let page = document.createElement("li");
                page.className = "page-item";
                page.innerHTML = ` <button class="page-link" aria-label="Previous">
                                            <span aria-hidden="true">${
                                                index + 1
                                            }</span>
                                        </a>`;
                page.addEventListener("click", () => {
                    getSucursales(index, tamanopagina).then((response) => {
                        ShowSucursales(response.value);
                    });
                });
                pag.append(page);
            }
    
            let next = document.createElement("next");
            next.className = "page-item";
            next.innerHTML = ` <button class="page-link" aria-label="next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>`;
            next.addEventListener("click", () => {
                getSucursales(pagina - 1, tamanopagina).then((response) => {
                    ShowSucursales(response.value);
                });
            });
            pag.append(next);
};
cargarData();
