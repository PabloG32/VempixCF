const EXCECUTE_HANDLER = Symbol('excecuteHandler');
class VempixcfView {

    constructor() {
        this.main = document.getElementsByTagName('main')[0];
        this.productosC = document.getElementById('productos-centro');
        this.catMenu = document.getElementById('cat-menu');
        this.categoriesMenu = document.getElementById('categories-menu');
        this.categories = document.getElementById('cat-centro');
        this.menu = document.querySelector('#nav-menu');
        this.productosCat = document.getElementById('prodMain');
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
                  <button type="button" class="btn btn-sm btn-outline-secondary" id="botonInfo" data-name="${producto.nombre}">Información</button>
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
        for (let i = 0; i < 6; i++) {
            const randomIndex = Math.floor(Math.random() * productos.length);
            aleatorios.push(productos[randomIndex]);
            productos.splice(randomIndex, 1);
        }
        return aleatorios;
    }


    bindShowProductoInfoIndex(handler) {
        const botonInfo = document.getElementById("botonInfo");
        for (const botonInfo of this.productosC.children) {
            botonInfo.addEventListener('click', (event) => {
                handler(event.target.dataset.name);

            });
        }
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
        container.id = 'new-prod';
        container.insertAdjacentHTML(
            'beforeend', `
                <div class="container-return">
                    <a href=""><i class="fa-solid fa-arrow-left"></i></a>
                </div>
            <div class="d-flex justify-content-center align-items-center">
                    <h1 class="display-5">Menu de productos</h1>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <ul class="list-group">
                        <li class="list-group-item"><a href="../php/newProducto.php">Añadir un nuevo producto</a></li>
                        <li class="list-group-item"><a href="../php/controller.php?operacion=listadoproductos">Listar los productos</a></li>
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
        <div class="container-return">
            <a href=""><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <div class="album py-5" id="prodMain">
            <h2 class="display-5 fw-bold text-center">${nombre}</h2>
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="productosMain">
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
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="botonInfo" data-name="${producto.nombre}">Información</button>
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

        this.main.insertAdjacentHTML('afterbegin', productosHTML);
    }


    bindShowProductoInfoCat(handler) {
        const botonInfo = document.getElementById("botonInfo");
        for (const botonInfo of this.main.children) {
            botonInfo.addEventListener('click', (event) => {
                handler(event.target.dataset.name);

            });
        }
    }

    //Añadir un producto
    bindNewCategoria(handler) {
        const newCategoria = document.getElementById('newCategoria');
        newCategoria.addEventListener('click', (event) => {
            handler();
        });
    }

    //Formulario para menu de producto
    showMenuCategoria() {
        this.main.replaceChildren();
        const container = document.createElement('div');
        container.classList.add('container');
        container.classList.add('my-3');
        container.id = 'new-cat';
        container.insertAdjacentHTML(
            'beforeend', `
                    <div class="container-return">
                        <a href=""><i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                <div class="d-flex justify-content-center align-items-center">
                        <h1 class="display-5">Menu de productos</h1>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="../php/newCategoria.php">Añadir una nueva categoria</a></li>
                            <li class="list-group-item"><a href="../php/controller.php?operacion=listadocategorias">Listar las categorias</a></li>
                        </ul>
                    </div>
    
            `,
        );
        this.main.append(container);
    }

    //----------------------------------------------------------Pagina de info----------------------------------------------------------------

    //Mostrar info del producto
    showProductoInfo(producto) {
        const main = document.querySelector('main');
        main.replaceChildren();

        // Agregar el título
        const containerTitle = document.createElement('div');
        containerTitle.className = 'container-title';
        const title = document.createElement('h1');
        title.textContent = `${producto.nombre}`;
        containerTitle.appendChild(title);
        main.appendChild(containerTitle);

        // Agregar el enlace para volver
        const containerReturn = document.createElement('div');
        containerReturn.className = 'container-return';
        const link = document.createElement('button');
        link.onclick = () => {
            window.location.href = '../php/tienda.php';
        };
        link.innerHTML = '<i class="fa-solid fa-arrow-left"></i>';
        containerReturn.appendChild(link);
        main.appendChild(containerReturn);

        // Crear el contenedor principal de información
        const mainInfo = document.createElement('div');
        mainInfo.className = 'main-info';

        // Crear el contenedor de imagen
        const containerImg = document.createElement('div');
        containerImg.className = 'container-img';
        const img = document.createElement('img');
        img.src = `data:image/jpg;base64,${producto.imagen}`;
        img.alt = `Imagen de ${producto.nombre}`;
        containerImg.appendChild(img);

        // Crear el contenedor de información del producto
        const containerInfo = document.createElement('div');
        containerInfo.className = 'container-info-product';

        // Información de precio
        const containerPrice = document.createElement('div');
        containerPrice.className = 'container-price';
        const spanPrice = document.createElement('span');
        spanPrice.textContent = `${producto.precio.toFixed(2)}€`;
        const iconArrow = document.createElement('i');
        iconArrow.className = 'fa-solid fa-angle-right';
        containerPrice.appendChild(spanPrice);
        containerPrice.appendChild(iconArrow);
        containerInfo.appendChild(containerPrice);

        // Detalles del producto
        const containerDetails = document.createElement('div');
        containerDetails.className = 'container-details-product';

        // Select de color
        const formGroupColor = document.createElement('div');
        formGroupColor.className = 'form-group';
        const labelColor = document.createElement('label');
        labelColor.htmlFor = 'color';
        labelColor.textContent = 'Color';
        const selectColor = document.createElement('select');
        selectColor.id = 'color';
        selectColor.name = 'color';
        selectColor.innerHTML = `
            <option disabled selected value="">Selecciona una opción</option>
            <option value="rojo">Rojo</option>
            <option value="blanco">Blanco</option>
            <option value="azul">Azul</option>
        `;
        formGroupColor.appendChild(labelColor);
        formGroupColor.appendChild(selectColor);

        // Select de talla
        const formGroupSize = document.createElement('div');
        formGroupSize.className = 'form-group';
        const labelSize = document.createElement('label');
        labelSize.htmlFor = 'talla';
        labelSize.textContent = 'Talla';
        const selectSize = document.createElement('select');
        selectSize.id = 'talla';
        selectSize.name = 'talla';
        selectSize.innerHTML = `
            <option disabled selected value="">Selecciona una opción</option>
            <option value="XS">XS</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
        `;
        formGroupSize.appendChild(labelSize);
        formGroupSize.appendChild(selectSize);

        containerDetails.appendChild(formGroupColor);
        containerDetails.appendChild(formGroupSize);
        containerInfo.appendChild(containerDetails);

        // Botón añadir al carrito
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../php/accionesCarrito.php?accion=agregar';
        const containerAddCart = document.createElement('div');
        containerAddCart.className = 'container-add-cart';
        const id = document.createElement('input');
        id.type = 'hidden';
        id.name = 'id';
        id.value = `${producto.id}`;
        const containerQuantity = document.createElement('div')
        containerQuantity.className = 'container-quantity';
        const quantity = document.createElement('input');
        quantity.type = 'number';
        quantity.placeholder = '1';
        quantity.value = '1';
        quantity.min = '1';
        quantity.className = 'input-quantity';
        quantity.name = 'cantidad';
        const buttonAddToCart = document.createElement('input');
        buttonAddToCart.type = 'submit'
        buttonAddToCart.className = 'btn-add-to-cart';
        buttonAddToCart.name = 'accion';
        buttonAddToCart.value = 'Añadir al carrito';
        containerAddCart.appendChild(id);
        containerQuantity.appendChild(quantity);
        containerAddCart.appendChild(containerQuantity);
        containerAddCart.appendChild(buttonAddToCart);
        form.appendChild(containerAddCart);
        containerInfo.appendChild(form);

        // Descripción del producto
        const containerDescription = document.createElement('div');
        containerDescription.className = 'container-description';
        const titleDescription = document.createElement('div');
        titleDescription.className = 'title-description';
        titleDescription.innerHTML = `<h4>Descripción</h4><i class="fa-solid fa-chevron-down"></i>`;
        const textDescription = document.createElement('div');
        textDescription.className = 'text-description';
        textDescription.innerHTML = `<p>${producto.descripcion}</p>`;
        containerDescription.appendChild(titleDescription);
        containerDescription.appendChild(textDescription);
        containerInfo.appendChild(containerDescription);

        //Social
        const containerSocial = document.createElement('div');
        containerSocial.className = 'container-social';
        const spanSocial = document.createElement('span');
        spanSocial.textContent = 'Compartir';
        const containerBtnSocial = document.createElement('div');
        containerBtnSocial.className = 'container-buttons-social';
        containerBtnSocial.innerHTML = `<a href="#"><i class="fa-solid fa-envelope"></i></a>
						<a href="#"><i class="fa-brands fa-facebook"></i></a>
						<a href="#"><i class="fa-brands fa-twitter"></i></a>
						<a href="#"><i class="fa-brands fa-instagram"></i></a>`

        containerSocial.appendChild(spanSocial);
        containerSocial.appendChild(containerBtnSocial);
        containerInfo.appendChild(containerSocial);

        mainInfo.appendChild(containerImg);
        mainInfo.appendChild(containerInfo);
        main.appendChild(mainInfo);
    }


    //----------------------------------------------------------Noticias----------------------------------------------------------------

    //Ver noticias
    bindNoticias(handler) {
        const showNoticias = document.getElementById('showNoticias');
        showNoticias.addEventListener('click', (event) => {
            handler();
        });
    }

    //Mostrar noticias
    showNoticias(noticias) {
        const main = document.querySelector('main');
        main.replaceChildren();

        // Crear el contenedor principal
        const mainNoticias = document.createElement('div');
        mainNoticias.className = 'container px-4 py-5';
        mainNoticias.id = 'custom-cards';
        main.appendChild(mainNoticias);

        const tituloPag = document.createElement('h2');
        tituloPag.className = 'pb-2 border-bottom';
        tituloPag.textContent = 'Noticias';
        mainNoticias.appendChild(tituloPag);

        const divTarjetas = document.createElement('div');
        divTarjetas.className = 'row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5';
        for (const noticia of noticias) {
            const containerNot = document.createElement('div');
            containerNot.className = 'col';
            containerNot.innerHTML = `
                <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="background-color: black;">
                    <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                        <h3 class="mb-4 lh-1 fw-bold">${noticia.titulo}</h3>
                        <ul class="d-flex list-unstyled mt-auto">
                            <li class="d-flex align-items-center me-3">
                                <small>CrossFit</small>
                            </li>
                            <li class="d-flex justify-content-end align-items-center">
                                <small class="me-2">${noticia.fecha}</small>
                                <i class="fa-solid fa-calendar-days"></i>
                            </li>
                        </ul>
                        <button class="btn btn-primary mt-3 w-100" data-bs-toggle="modal" data-bs-target="#${noticia.id}">Leer más</button>
                    </div>
                </div>

                <div class="modal fade" id="${noticia.id}" tabindex="-1" aria-labelledby="noticiaModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="noticiaModalLabel">${noticia.titulo}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <img src="data:image/jpg;base64,${noticia.imagen}" alt="${noticia.titulo}" class="img-fluid rounded mb-3">
                                <p>${noticia.contenido}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `
            divTarjetas.appendChild(containerNot);
        }

        mainNoticias.appendChild(divTarjetas);
    }


    //Añadir un producto
    bindNewNoticia(handler) {
        const newNoticia = document.getElementById('newNoticia');
        newNoticia.addEventListener('click', (event) => {
            handler();
        });
    }

    //Formulario para menu de noticias
    showMenuNoticia() {
        this.main.replaceChildren();
        const container = document.createElement('div');
        container.classList.add('container');
        container.classList.add('my-3');
        container.id = 'new-no';
        container.insertAdjacentHTML(
            'beforeend', `
                    <div class="container-return">
                        <a href=""><i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                <div class="d-flex justify-content-center align-items-center">
                        <h1 class="display-5">Menu de noticias</h1>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="../php/newNoticia.php">Añadir una nueva noticia</a></li>
                            <li class="list-group-item"><a href="../php/controller.php?operacion=listadonoticias">Listar las noticias</a></li>
                        </ul>
                    </div>

            `,
        );
        this.main.append(container);
    }

}

export default VempixcfView;