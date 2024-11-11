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
    }


    handleInit = () => {
        this.onInit();
    }

    onLoad = async () => {
        await this.createData();
        this.onProductos();
    }



    onProductos() {
        const productos = this[MODEL].productos;
        this[VIEW].showProductos(productos);
    }


    async createData() {
        await fetch("../js/productos.json", { method: "post" }).then((response) => response.json()).then((data) => {
            for (const producto of data.productos) {
                this[MODEL].addProducto(this[MODEL].createProducto(producto.nombre, producto.descripcion, producto.precio, producto.imagen, producto.categoria));
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
}
export default VempixcfController;