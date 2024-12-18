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
        this.onCategorias();
        const adminMenu = document.getElementById('adminMenu');
        if (adminMenu && adminMenu.style.display !== 'none') {
            this[VIEW].bindNewProducto(this.handlerNewProducto);
            this[VIEW].bindNewCategoria(this.handlerNewCategoria);
            this[VIEW].bindNewNoticia(this.handlerNewNoticia);
        }
    }

    onLoad = async () => {
        await this.createData();
        this.onProductos();
        this.onCategorias();
        this.onNoticias();

    }

    onProductos() {
        const productos = this[MODEL].productos;
        this[VIEW].showProductos(productos);
        this[VIEW].bindShowProductoInfoIndex(this.handlerShowProductoInfo)
    }

    onCategorias() {
        const categorias = this[MODEL].categorias;
        this[VIEW].showCategoriasMenu(categorias);
        this[VIEW].bindCategoriasMenu(this.handlerShowCategoriasProductos);
    }

    onNoticias() {
        this[VIEW].bindNoticias(this.handlerNoticia);
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

            for (const noticia of data.noticias) {
                this[MODEL].addNoticia(this[MODEL].createNoticia(noticia.titulo, noticia.contenido, noticia.fecha, noticia.imagen, noticia.id));
            }

        });
    }

    handlerShowCategoriasProductos = (nombre) => {
        const categoria = this[MODEL].createCategoria(nombre);
        const productos = this[MODEL].getProductosInCategoria(categoria);
        this[VIEW].showProductosInCategoria(productos, nombre);
        this[VIEW].bindShowProductoInfoCat(this.handlerShowProductoInfo)
    }

    handlerShowProductoInfo = (nombre) => {
        const producto = this[MODEL].createProducto(nombre);
        this[VIEW].showProductoInfo(producto);
    }

    //Creacion de productos
    handlerNewProducto = () => {
        this[VIEW].showMenuProducto();
    }

    //Creacion de categorias
    handlerNewCategoria = () => {
        this[VIEW].showMenuCategoria();
    }

    handlerNewNoticia = () => {
        this[VIEW].showMenuNoticia();
    }

    handlerNoticia = () => {
        const noticias = this[MODEL].noticias;
        this[VIEW].showNoticias(noticias);
    }
}
export default VempixcfController;