const EXCECUTE_HANDLER = Symbol('excecuteHandler');
class VempixcfView {

    constructor() {
        this.main = document.getElementsByTagName('main')[0];
        this.productosC = document.getElementById('productos-centro');
        this.catMenu = document.getElementById('cat-menu');
        this.categoriesMenu = document.getElementById('categories-menu');
        this.categories = document.getElementById('cat-centro');
    }

    //----------------------------------------------------------USER----------------------------------------------------------------

    showIdentificationLink() {
        const userArea = document.getElementById('userArea');
        userArea.replaceChildren();
        userArea.insertAdjacentHTML('afterbegin', `<div class="account d-flex
    mx-2 flex-column" style="text-align: right; height: 40px">
    <a id="login" href="#"><i class="bi bi-person-circle" ariahidden="true"></i><img class="mb-4" src="../img/login.png" alt="login"><i</a>
</div>`);
    }

    bindIdentificationLink(handler) {
        const login = document.getElementById('login');
        login.addEventListener('click', (event) => {
            handler();
        });
    }

    //Formulario de login
    showLogin() {
        this.main.replaceChildren();
        const login = `
<main class="form-signin w-100 m-auto">
    <form>
        <img class="mb-4" src="../img/Logo.jpeg" alt="" width="200" height="200">
        <h1 class="h3 mb-3 fw-normal">Inicio de sesion</h1>

        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Recordar
            </label>
        </div>
        <div class="form-check text-start my-3">
            <a id="registro" href="#"><i class="bi bi-person-circle" ariahidden="true"></i>Registrarse</a>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Iniciar sesión</button>

    </form>
</main>
`;
        this.main.insertAdjacentHTML('afterbegin', login);
    }

    bindRegisterLink(handler) {
        const registro = document.getElementById('registro');
        registro.addEventListener('click', (event) => {
            handler();
        });
    }

    showRegister() {
        this.main.replaceChildren();
        const registro = `
<main class="form-signin w-100 m-auto">
    <form name='f1' method='POST' action='../php/registro.php'>
        <fieldset>
            <legend>Registro de usuario</legend>

            <!--Campo nombre-->
            <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                    <label class="form-label" for="form3Example1c">Nombre: *</label>
                    <input type="text" name="nombre" id="form3Example1c" class="form-control" required />
                </div>
            </div>

            <!--Campo Email-->
            <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                    <label class="form-label" for="form3Example3c">Email: *</label>
                    <input type="email" name="email" id="form3Example3c" class="form-control" required />
                </div>
            </div>

            <!-- Campo contraseña -->
            <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                    <label class="form-label" for="form3Example4c">Contraseña: *</label>
                    <input type="password" name="password" id="form3Example4c" class="form-control" required />
                </div>
            </div>

            <!--Campo Direccion  -->
            <div class="d-flex flex-row align-items-center mb-4">
                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                    <label class="form-label" for="form3Example1c">Dirección: *</label>
                    <input type="text" name="direccion" id="form3Example1c" class="form-control" required />
                </div>
            </div>

            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                <input type='submit' name='alta' value='Registrarse' class="btn btn-primary btn-lg">
            </div>
        </fieldset>
    </form>
</main>
`;
        this.main.insertAdjacentHTML('afterbegin', registro);
    }



    //----------------------------------------------------------PRODUCTOS----------------------------------------------------------------
    showProductos(productos) {
        const productosAleatorios = this.obtenerProductosAleatorios(productos);
        this.productosC.replaceChildren();
        for (const producto of productosAleatorios) {
            this.productosC.insertAdjacentHTML('beforeend', `
            <div class="col">
            <div class="card shadow-sm">
            <img src='data:image/jpg;base64,${producto.imagen}' alt="${producto.nombre}" class="card-img-top" style="height: 300px; object-fit: cover;">
                <div class="card-body">
                <p class="card-text">${producto.nombre}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#info${producto.nombre}">Información</button>
                    </div>
                </div>
            </div>
            </div>
            </div>
            <!-- Modal info -->
        <div class="modal fade" id="info${producto.nombre}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="modalHeader">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">${producto.nombre}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <p>
                            Nombre: ${producto.nombre}
                            <br><br>
                            Descripción: ${producto.descripcion}
                            <br><br>
                            Categoria: ${producto.categoria}
                            <br><br>
                            Precio: ${producto.precio}
                            <br><br>
                            Imagen: <img src='data:image/jpg;base64,${producto.imagen}' alt="${producto.nombre}" width="200px" height="140px">
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> <!--Fin modal-->
        `)
        }
    }



    obtenerProductosAleatorios(iterable) {
        const productos = [...iterable];
        const aleatorios = [];
        for (let i = 0; i < 3; i++) {
            const randomIndex = Math.floor(Math.random() * productos.length);
            aleatorios.push(productos[randomIndex]);
            productos.splice(randomIndex, 1);
        }
        return aleatorios;
    }






    //----------------------------------------------------------CATEGORIAS----------------------------------------------------------------

    showCategoriasMenu(categorias) {
        this.catMenu.replaceChildren();
        for (const categoria of categorias) {
            this.catMenu.insertAdjacentHTML('beforeend', `<li><a id="cat-menu" data-categoria="${categoria.nombre}" class="dropdown-item" href="#">${categoria.nombre}</a></li>`)
        }
    }


    bindCategoriasMenu(handler) {
        for (const li of this.catMenu.children) {
            li.firstElementChild.addEventListener('click', (event) => {
                handler(event.currentTarget.dataset.categoria);
            });
        }
    }


    showProductosInCategoria(productos, nombre) {
        this.main.replaceChildren();
        this.main.insertAdjacentHTML('afterbegin', `<h2 class="mb-4 text-center">${nombre}</h2>`);
        let rowContainer = null; // Contenedor de cada fila de dos productos

        productos.forEach((producto, index) => {
            // Al comenzar una nueva fila
            if (index % 2 === 0) {
                rowContainer = document.createElement('div');
                rowContainer.classList.add('row', 'mb-4'); // Añadimos una clase de fila
                this.main.appendChild(rowContainer); // Añadimos la fila al contenedor principal
            }

            // Insertamos el producto dentro de la fila
            rowContainer.insertAdjacentHTML('beforeend', `
            <div class="col-md-6">
                <div class="text-bg-dark me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">
                    <div class="my-3 py-3">
                        <h2 class="display-5">${producto.nombre}</h2>
                        <p class="lead">${producto.descripcion}</p>
                    </div>
                    <div class="bg-body-tertiary shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
                        <img src='data:image/jpg;base64,${producto.imagen}' alt="${producto.nombre}" width="100%" height="100%">
                    </div>
                </div>
            </div>
        `); // Añadimos el producto a la fila
        });
    }


}

export default VempixcfView;