import { Producto } from './VempixcfModel.js';
import VempixcfManager from './VempixcfModel.js';

const manager = VempixcfManager.getInstance();

// Añadir Produccion
// const prodcuto = new Producto("Produccion 1", "prueba", 12, "img");

// try {
//     manager.addProducto(prodcuto);
//     console.log("Producto añadido correctamente");
// } catch (error) {
//     console.error(error);
// }

// //Intentar añadir la misma Produccion nuevamente debería lanzar un error
// // try {
// //     manager.insertProduction(produccion1);
// // } catch (error) {
// //     console.error(error.message);
// // }

// // Mostrar valores
// console.log("Mostrar valores: ");
// console.log(prodcuto.toString());

const fr = manager.createProducto("Prueba2", "pruebaaaaa", 12, "combas");

try {
    const f = manager.addProducto(fr)
    console.log("Producto añadido correctamente");
} catch (error) {
    console.error(error);
}

console.log("Mostrar valores: ");
console.log(fr.toString());

// const produccionBorrar = new Production("Produccion Borrar");
// try {
//     manager.insertProduction(produccionBorrar);
//     console.log("Categorías para borrar añadida correctamente");
//     console.log(produccionBorrar.toString());
// } catch (error) {
//     console.error(error);
// }

// try {
//     manager.removeProduction(produccionBorrar);
//     console.log("Eliminado bien, despues de eliminar la produccion produccionBorrar:");
//     // result = manager.toString();
//     // console.log(result);
// } catch (error) {
//     console.error(error.message);
// }



// const production4 = new Production("production4");
// const production5 = new Production("production5");
// const person6 = new Person("person6");
// const person7 = new Person("person7");

// manager.insertProduction(production4, production5);
// manager.insertPerson(person6, person7);


// try {
//     manager.assignDirector(production4, person6, person7);
// } catch (error) {
//     console.log(error.message);
// }