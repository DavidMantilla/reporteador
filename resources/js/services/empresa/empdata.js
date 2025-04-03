import axios from "axios";
import config from'../../config/api';
const EmpresasUrl = `${config.OdataUrl}/Empresas`;
let total = 0;
let pagina = 0;
let tamanopagina = 9;

export const getEmpresas = async (page, pageSize) => {
    try {
        const response = await axios.get(
            `${EmpresasUrl}?$top=${pageSize}&$skip=${
                page * pageSize
            }&$count=true`
        );
        return response.data;
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
};



const showUser = (response) => {
    console.log(response);

    const usuario = document.getElementById("listEmpresa");
    usuario.innerHTML = "";
    response.forEach((element) => {
        const container = document.createElement("div");
        container.className = "col-md-4";
        container.innerHTML = ` <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-10"><b>${element.NomComercial.toUpperCase()}</b></div>
                                        <div class="col-2"><a href="nuevaempresa?id=${
                                            element.Id_Empresa
                                        }"><span class="fa-solid fa-pen"
                                                    style="color:#EE5D31"></a>
                                            </span></div>
                                        <div class="col-6" style="font-size: 12px"> <b>FECHA:</b><span> ${
                                            element.FechaAlta
                                        }</span>
                                        </div>
                                        <div class="col-6" style="font-size: 12px"> <b>Estado:</b><span
                                                style="${
                                                    element.Estado == "ACTIVO"
                                                        ? "color: #EE5D31"
                                                        : "color:rgb(241, 17, 17)"
                                                } "> ${
            element.Estado
        }</span> </div>
                                        <div class="col-12" style="font-size: 12px"> <b>GUID:</b> <span>
                                                13415056-AD43-40F9-92FB-D2145AE62351</span> </div><br>
                                        <div class="col-12" style="font-size: 12px"> <br><br>
                                        <a href="sucursales/${element.Id_Empresa}" class="btn btn-primary " style="color:#fff">sucursales</a>
                                        </div><br>        
                                    </div>
                                </div>
                            </div>  `;

        usuario.append(container);
    });
};


const selectEmp=(response)=>{
    console.log(response);
    
    const slempresa = document.getElementById("slempresa");
    slempresa.innerHTML="<option value=''>Seleccione empresa</option>";
    slempresa.style.textTransform="Capitalize";
    response.forEach((element)=>{

     let option=document.createElement("option");
     option.style.textTransform="Capitalize";
     option.value=`${element.Id_Empresa}`;
     option.innerHTML=`${element.NomComercial.toLowerCase()}`
     slempresa.append(option);

    });
} 


if(document.getElementById("slempresa")){

getEmpresas(0,100).then((response)=>{


    selectEmp(response.value)
})
}


if (document.getElementById("listEmpresa")) {
    getEmpresas(0, tamanopagina).then((response) => {
        total = response["@count"];

        pagina = Math.ceil(total / tamanopagina);

        showUser(response.value);
        let pag = document.getElementById("pag-empresa");
        pag.innerHTML = "";
        let previous = document.createElement("li");
        previous.className = "page-item";
        previous.innerHTML = ` <button class="page-link" >
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>`;
        previous.addEventListener("click", () => {
            getEmpresas(0, tamanopagina).then((response) => {
                showUser(response.value);
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
                getEmpresas(index, tamanopagina).then((response) => {
                    showUser(response.value);
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
            getEmpresas(pagina - 1, tamanopagina).then((response) => {
                showUser(response.value);
            });
        });
        pag.append(next);

        console.log(pagina);
    });
}




