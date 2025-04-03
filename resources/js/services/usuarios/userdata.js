import axios from "axios";
import config from'../../config/api';

const UsersUrl = `${config.OdataUrl}User`;
let total = 0;
let pagina = 0;
let tamanopagina = 9;

export const getUsers = async (page, pageSize) => {
    //log de paginas y tamaño de pagina
    console.log(`Page: ${page}, Page Size: ${pageSize}`);

    try {
        let cons = `${UsersUrl}?$top=${pageSize}&$skip=${
            page * pageSize
        }&$count=true `;
        console.log(cons);

        const response = await axios.get(cons);
        return response.data;
    } catch (error) {
        console.error("Error fetching users:", error);
        throw error;
    }
};

const showUser = (response) => {
    console.log(response);

    const usuario = document.getElementById("listausuario");
    usuario.innerHTML = "";
    response.forEach((element) => {
        const container = document.createElement("div");
        container.className = "col-md-4";
        container.innerHTML = `<div class="card">
        <div class="card-body">
        <div class="row">
        <div class="col-10"><b>${element.Nombre}</b></div>
                                        <div class="col-2"><a href="nuevousuario?id=${
                                            element.Id_Usuario
                                        }"><span class="fa-solid fa-pen"
                                        style="color:#EE5D31"></a>
                                            </span></div>
                                        <div class="col-8" style="font-size: 12px"> <b>correo:</b> <span>
                                                ${
                                                    element.Correo
                                                }</span> </div><br>

                                                <div class="col-3" style="font-size: 12px"><span style="color: #EE5D31">
                                                ${
                                                    element.Admin ? "Admin" : ""
                                                }</span> </div>
                                    </div>
                                    </div>
                                    `;

        usuario.append(container);
    });
};

if (document.getElementById("listausuario")) {
    getUsers(0, tamanopagina).then((response) => {
        total = response["@count"];

        pagina = Math.ceil(total / tamanopagina);

        showUser(response.value);
        let pag = document.getElementById("pag-user");
        pag.innerHTML = "";
        let previous = document.createElement("li");
        previous.className = "page-item";
        previous.innerHTML = ` <button class="page-link"  aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </button>`;
        previous.addEventListener("click", () => {
            getUsers(0, tamanopagina).then((response) => {
                showUser(response.value);
            });
        });
        pag.append(previous);

        for (let index = 0; index < pagina; index++) {
            //log avance de ciclo

            let page = document.createElement("li");
            page.className = "page-item";
            page.innerHTML = ` <button class="page-link" >
                                        <span aria-hidden="true">${
                                            index + 1
                                        }</span>
                                    </button>`;
            page.addEventListener("click", () => {
                getUsers(index, tamanopagina).then((response) => {
                    showUser(response.value);
                });
            });
            pag.append(page);
            console.log(pag);
        }

        let next = document.createElement("li");
        next.className = "page-item";
        next.innerHTML = ` <button class="page-link" aria-label="next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </button>`;
        next.addEventListener("click", () => {
            getUsers(pagina - 1, tamanopagina).then((response) => {
                showUser(response.value);
            });
        });
        pag.append(next);

        console.log(pagina);
    });
}
