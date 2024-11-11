"use strict";

import {
    BaseException,
    InvalidAccessConstructorException,
    EmptyValueException,
    InvalidValueException,
    AbstractClassException,
} from "./exceptions.js";

class Producto {
    //Propiedades
    #nombre; //Nombre del producto
    #descripcion; //Descripcion del producto
    #precio; //Valor del producto
    #imagen; //Imagen del producto
    #categoria; //Categoria del producto

    //Constructor
    constructor(nombre, descripcion, precio, imagen = "", categoria) {
        //Excepciones
        if (!new.target) throw new InvalidAccessConstructorException();
        if (!nombre) throw new EmptyValueException("nombre");
        if (!descripcion) throw new EmptyValueException("descripcion");
        if (!precio) throw new EmptyValueException("precio");
        if (!imagen) throw new EmptyValueException("imagen");
        if (typeof nombre != "string") throw new InvalidValueException("nombre", "String");
        if (typeof descripcion != "string") throw new InvalidValueException("descripcion", "String");
        if (typeof precio != "number") throw new InvalidValueException("precio", "Number");
        // if (typeof imagen != "string") throw new InvalidValueException("imagen", "String");

        this.#nombre = nombre;
        this.#descripcion = descripcion;
        this.#precio = precio;
        this.#imagen = imagen;
        this.#categoria = categoria;

        //Propiedades
        Object.defineProperty(this, 'nombre', {
            enumerable: true,
            get() {
                return this.#nombre;
            },
            set(value) {
                if (!value) throw new EmptyValueException('nombre');
                this.#nombre = value;
            },
        });

        Object.defineProperty(this, 'descripcion', {
            enumerable: true,
            get() {
                return this.#descripcion;
            },
            set(value) {
                if (!value) throw new EmptyValueException('descripcion');
                this.#descripcion = value;
            },
        });

        Object.defineProperty(this, 'precio', {
            enumerable: true,
            get() {
                return this.#precio;
            },
            set(value) {
                if (!value) throw new EmptyValueException('precio');
                this.#precio = value;
            },
        });

        Object.defineProperty(this, 'imagen', {
            enumerable: true,
            get() {
                return this.#imagen;
            },
            set(value) {
                if (!value) throw new EmptyValueException('imagen');
                this.#imagen = value;
            },
        });

        Object.defineProperty(this, 'categoria', {
            enumerable: true,
            get() {
                return this.#categoria;
            },
            set(value) {
                if (!value) throw new EmptyValueException('categoria');
                this.#categoria = value;
            },
        });

    }
    toString() {
        return `Producto: ${this.#nombre} Descripción: ${this.#descripcion} Precio: ${this.#precio} Imagen: ${this.#imagen} Categoria: ${this.#categoria}`;
    }
}



class Categoria {
    //Propiedades
    #nombre; //Nombre de la categoría.

    //Constructor
    constructor(nombre) {
        //Excepciones
        if (!new.target) throw new InvalidAccessConstructorException();
        if (!nombre) throw new EmptyValueException("nombre");
        if (typeof nombre != "string") throw new InvalidValueException("nombre", "String");

        this.#nombre = nombre;

        // Propiedades de acceso a los atributos privados enumerables.
        Object.defineProperty(this, 'nombre', {
            enumerable: true,
            get() {
                return this.#nombre;
            },
            set(value) {
                if (!value) throw new EmptyValueException('nombre');
                this.#nombre = value;
            },
        });

    }

    toString() {
        return `Category: ${this.#nombre}`;
    }
}




//Excepciones
class ManagerException extends BaseException {
    constructor(message = 'Error: Manager Exception.', fileName, lineNumber) {
        super(message, fileName, lineNumber);
        this.name = 'ManagerException';
    }
}

class ObjecManagerException extends ManagerException {
    constructor(param, className, fileName, lineNumber) {
        super(`Error: The ${param} is not a ${className}`, fileName, lineNumber);
        this.param = param;
        this.className = className;
        this.name = 'ObjecManagerException';
    }
}

class ProductoExistsException extends ManagerException {
    constructor(producto, fileName, lineNumber) {
        super(`Error: The ${producto.name} already exists in the manager.`, fileName, lineNumber);
        this.producto = producto;
        this.name = 'ProductoExistsException';
    }
}


let VempixcfManager = (function () {
    let instantiated;
    function init() { //Inicialización del Singleton

        class VempixcfManager {
            #productos = []; //Array de productos.
            #categorias = []; //Array de categorias.

            constructor() {
                Object.defineProperty(this, 'productos', {
                    enumerable: true,
                    get() { // Define un método 'get' para la propiedad 'dishes'
                        const array = this.#productos; // Obtiene el array privado asociado a 'productos'
                        return {
                            *[Symbol.iterator]() { // Define un iterador para el array
                                for (const producto of array) { // Itera sobre cada elemento del array
                                    yield producto; // Devuelve el elemento actual del array
                                }
                            },
                        };
                    },
                });


                Object.defineProperty(this, 'categorias', {
                    enumerable: true,
                    get() {
                        const array = this.#categorias;
                        return {
                            *[Symbol.iterator]() {
                                for (const arrayCategory of array) {
                                    yield arrayCategory.categoria;
                                }
                            },
                        };
                    },
                });

            }

            //Dado un producto, devuelve su posición.
            #getProductoPosicion(nombre) {
                function compareElements(element) {
                    return (element.nombre === nombre); // Devuelve true si el nombre del elemento coincide con el nombre dado
                }
                // Utiliza 'findIndex' para encontrar la posición del primer elemento en '#productos' cuyo nombre coincida con 'name'
                return this.#productos.findIndex(compareElements);
            }


            //Dado una categoría, devuelve su posición
            #getCategoriaPosicion(nombre) {
                function compareElements(element) {
                    return (element.categoria.nombre === nombre)
                }

                return this.#categorias.findIndex(compareElements);
            }



            //Obtiene un iterador con la relación de los platos a una categoría
            *getProductosInCategoria(categoria) {
                if (!(categoria instanceof Categoria)) {
                    throw new ObjecManagerException('categoria', 'Categoria');
                }

                let positionCat = this.#getCategoriaPosicion(categoria.nombre);
                if (positionCat === -1) {
                    throw new CategoryNotExistException(categoria);
                }
                let productos;

                productos = this.#categorias[positionCat].productos;

                // Genera cada plato en la categoría
                for (let producto of productos) {
                    yield producto;// Devuelve el plato actual
                }
            }



            //******************************************************************Productos****************************************** */
            //Añade un nuevo producto
            addProducto(...productos) {
                for (let producto of productos) {
                    if (!(producto instanceof Producto)) {
                        throw new ObjecManagerException('producto', 'Producto');
                    }
                    // Obtiene la posición del plato en el manager de objetos
                    let position = this.#getProductoPosicion(producto.nombre);
                    if (position === -1) {  // Si el plato no existe en el manager, lo añade
                        this.#productos.push(producto);
                    } else {
                        throw new ProductoExistsException(producto);
                    }
                }
                return this;
            }

            //Devuelve un objeto Dish si está registrado, o crea un nuevo
            createProducto(nombre, descripcion = "", precio, imagen = " ", categoria) {
                let position = this.#getProductoPosicion(nombre);
                if (position != -1) return this.#productos[position]; // Si el producto ya existe en el manager, lo devuelve
                return new Producto(nombre, descripcion, precio, imagen, categoria); // Si el producto no existe, crea uno nuevo y lo devuelve
            }











            //******************************************************************Productos****************************************** */



            //Añade una nueva categoria
            addCategoria(...categorias) {
                for (let categoria of categorias) {
                    if (!(categoria instanceof Categoria)) {
                        throw new ObjecManagerException('categoria', 'Categoria');
                    }
                    let position = this.#getCategoriaPosicion(categoria.nombre);
                    if (position === -1) {
                        this.#categorias.push(
                            {
                                categoria: categoria,
                                productos: []
                            }
                        );
                    } else {
                        throw new CategoryExistsException(categoria);
                    }
                }
                return this;
            }

            //Devuelve un objeto Category si está registrado, o crea un nuevo.
            createCategoria(nombre) {
                let position = this.#getCategoriaPosicion(nombre);
                if (position != -1) return this.#categorias[position].categoria;
                return new Categoria(nombre);
            }

            //Asigna un plato a una categoría. Si el objeto Category o Dish no existen se añaden al sistema.
            assignCategoriaToProducto(categoria, ...productos) {
                if (!(categoria instanceof Categoria)) {
                    throw new ObjecManagerException('categoria', 'Categoria');
                }

                for (let producto of productos) {
                    if (!(producto instanceof Producto)) {
                        throw new ObjecManagerException('producto', 'Producto');
                    }
                }

                let positionCat = this.#getCategoriaPosicion(categoria.nombre);
                if (positionCat === -1) {
                    this.addCategoria(categoria);
                    positionCat = this.#getCategoriaPosicion(categoria.nombre);
                }

                for (let producto of productos) {
                    let positionProducto = this.#getProductoPosicion(producto.nombre);
                    if (positionProducto === -1) {
                        this.addProducto(producto);
                        positionProducto = this.#getProductoPosicion(producto.nombre);
                    }

                    // Verificar si el plato ya existe en la categoría
                    if (this.#categorias[positionCat].productos.includes(this.#productos[positionProducto])) {
                        throw new DishExistInCategoryException(producto, categoria);
                    }

                    // Asigna el plato a la categoría
                    this.#categorias[positionCat].productos.push(this.#productos[positionProducto]);
                }
                return this;
            }






        }
        let instance = new VempixcfManager();//Devolvemos el objeto RestaurantsManager para que sea una instancia única.
        Object.freeze(instance);
        return instance;
    }
    return {
        // Devuelve un objeto con el método getInstance
        getInstance: function () {
            if (!instantiated) { //Si la variable instantiated es undefined, priemera ejecución, ejecuta init.
                instantiated = init(); //instantiated contiene el objeto único
            }
            return instantiated; //Si ya está asignado devuelve la asignación.
        }
    };
})();

export {
    Producto
};

export default VempixcfManager;