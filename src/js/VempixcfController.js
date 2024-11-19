const MODEL = Symbol('VempixcfModel');
const VIEW = Symbol('VempixcfView');

class VempixcfController {
    constructor(VempixcfModel, VempixcfView) {
        this[MODEL] = VempixcfModel;
        this[VIEW] = VempixcfView;

        this.onLoad();

        this.onInit();

    }

    onInit = () => {
        this[VIEW].showIdentificationLink();
        this[VIEW].bindIdentificationLink(this.handleLoginForm);
        this.onCategorias();
        this[VIEW].showAdminMenu();
        this[VIEW].bindNewProducto(this.handlerNewProducto);

    }


    handleInit = () => {
        this.onInit();
    }

    onLoad = async () => {
        await this.createData();
        this.onProductos();
        this.onCategorias();

    }



    onProductos() {
        const productos = this[MODEL].productos;
        this[VIEW].showProductos(productos);
    }

    onCategorias() {
        const categorias = this[MODEL].categorias;
        this[VIEW].showCategoriasMenu(categorias);
        this[VIEW].bindCategoriasMenu(this.handlerShowCategoriasProductos);
    }


    async createData() {
        await fetch("../js/productos.json", { method: "post" }).then((response) => response.json()).then((data) => {
            for (const producto of data.productos) {
                this[MODEL].addProducto(this[MODEL].createProducto(producto.nombre, producto.descripcion, producto.precio, producto.imagen, producto.categoria, producto.id));
            }

            for (const categoria of data.categorias) {
                const storedCategoria = this[MODEL].createCategoria(categoria.nombre);
                this[MODEL].addCategoria(storedCategoria);
                if (categoria.productos) {
                    for (const producto of categoria.productos) {
                        const sotredProductos = this[MODEL].createProducto(producto);
                        this[MODEL].assignCategoriaToProducto(storedCategoria, sotredProductos);
                    }
                }
            }

        });
    }



    handleLoginForm = () => {
        this[VIEW].showLogin();
        this[VIEW].bindRegisterLink(this.handleRegis);
    };

    handleRegis = () => {
        this[VIEW].showRegister()
    }

    handlerShowCategoriasProductos = (nombre) => {
        const categoria = this[MODEL].createCategoria(nombre);
        const productos = this[MODEL].getProductosInCategoria(categoria);
        this[VIEW].showProductosInCategoria(productos, nombre);
    }

    //Creacion de productos
    handlerNewProducto = () => {
        this[VIEW].showMenuProducto();
    }
}
export default VempixcfController;