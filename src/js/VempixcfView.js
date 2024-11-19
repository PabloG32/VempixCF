const EXCECUTE_HANDLER = Symbol('excecuteHandler');
class VempixcfView {

    constructor() {
        this.main = document.getElementsByTagName('main')[0];
        this.productosC = document.getElementById('productos-centro');
        this.catMenu = document.getElementById('cat-menu');
        this.categoriesMenu = document.getElementById('categories-menu');
        this.categories = document.getElementById('cat-centro');
        this.menu = document.querySelector('#nav-menu');
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
            <section class="form-login">
                <form name='fLogin' method='POST'>
                    <h4>Iniciar sesion</h4>
                    <input class="controls" type="email" name="email" id="email" placeholder="Escribe un email" required>
                    <input class="controls" type="password" name="password" id="password" placeholder="Escribe una contraseña"
                        required>
                    <input type="checkbox" value="remember-me"> <label>Recordar</label>
                    <input class="botons" type="submit" value="Iniciar sesion">
                    <p><a id="registro" href="#">No tengo cuenta</a></p>
                    <input class="botons" onclick="window.location.href='../html/index.html';" type="button" value="Salir">
                </form>
            </section>
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
            <section class="form-register">
                <form name='fReg' method='POST' action='../php/registro.php'>
                    <h4>Registro de usuario</h4>
                    <input class="controls" type="text" name="nombre" id="nombre" placeholder="Escribe el nombre" required>
                    <input class="controls" type="email" name="email" id="email" placeholder="Escribe un email" required>
                    <input class="controls" type="password" name="password" id="password" placeholder="Escribe una contraseña"
                        required>
                    <input class="controls" type="text" name="direccion" id="direccion" placeholder="Escribe una direccion"
                        required>
                    <p>Estoy de acuerdo con <a href="#">Terminos y Condiciones</a></p>
                    <input class="botons" type="submit" name="alta" value="Registrarse">
                    <input class="botons" onclick="window.location.href='../html/index.html';" type="button" name="alta" value="Salir">
                </form>
            </section>
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
                  <button type="button" class="btn btn-sm btn-outline-secondary" id="botonInfo" data-id="${producto.id}">Información</button>
                </div>
                <small class="text-body-secondary">${producto.precio}€</small>
              </div>
            </div>
          </div>
        </div>
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


    //Añadir un producto
    bindNewProducto(handler) {
        const newProducto = document.getElementById('newProducto');
        newProducto.addEventListener('click', (event) => {
            handler();
        });
    }

    //Formulario para menu de producto
    showMenuProducto() {
        this.main.replaceChildren();
        const container = document.createElement('div');
        container.classList.add('container');
        container.classList.add('my-3');
        container.id = 'new-dish';
        container.insertAdjacentHTML(
            'beforeend', `
            <div class="d-flex justify-content-center align-items-center">
                    <h1 class="display-5">Menu de productos</h1>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <ul class="list-group">
                        <li class="list-group-item"><a href="../php/newProducto.php">Añadir un nuevo producto</a></li>
                        <li class="list-group-item"><a href="../php/controller.php?operacion=listadoproductos">Listar los productos</a></li>
                        <li class="list-group-item"><a href="../Vistas/consultaalumno.php">Consulta</a></li>
                    </ul>
                </div>

        `,
        );
        this.main.append(container);
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
        let productosHTML = '';
        let contador = 0;

        // Creamos el contenedor principal para los productos
        productosHTML += `
        <div class="album py-5">
            <h2 class="display-5 fw-bold text-center">${nombre}</h2>
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="productos-centro">
        `;

        for (const producto of productos) {
            // Añadir cada producto a la fila
            productosHTML += `
            <div class="col">
                <div class="card shadow-sm">
                    <img src='data:image/jpg;base64,${producto.imagen}' alt="${producto.nombre}" class="card-img-top" style="height: 300px; object-fit: cover;">
                    <div class="card-body">
                        <p class="card-text">${producto.nombre}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="botonInfo" data-id="${producto.id}">Información</button>
                            </div>
                            <small class="text-body-secondary">${producto.precio}€</small>
                        </div>
                    </div>
                </div>
            </div>
            `;

            // Cada vez que se agregan 3 productos, cerramos la fila y abrimos una nueva
            contador++;
            if (contador % 3 === 0) {
                productosHTML += '</div><div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
            }
        }

        // Si hay productos restantes después de completar el bucle
        if (contador % 3 !== 0) {
            productosHTML += '</div>';
        }

        // Cerramos el contenedor
        productosHTML += `
                </div>
            </div>
        </div>`;

        // Inserta el contenido generado en el main
        this.main.insertAdjacentHTML('afterbegin', productosHTML);
    }



    //----------------------------------------------------------USER----------------------------------------------------------------

    showAdminMenu() {
        const menuOption = document.createElement('li');
        menuOption.classList.add('nav-item');
        menuOption.classList.add('dropdown');
        menuOption.insertAdjacentHTML(
            'afterbegin',
            '<a class="nav-link dropdown-toggle" href="#" id="adminMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">Adminitración</a>',
        );
        const suboptions = document.createElement('ul');
        suboptions.classList.add('dropdown-menu');
        suboptions.insertAdjacentHTML('beforeend', '<li><a id="newProducto" class="dropdown-item" href="#">Productos</a></li>');
        menuOption.append(suboptions);
        this.menu.append(menuOption);
    }








}

export default VempixcfView;