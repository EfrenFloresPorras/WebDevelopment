let productos = {};

async function addProduct(i){
    let carrito = JSON.parse(localStorage.getItem('cart'));

    if (carrito == null) {
        carrito = [];
    }

    productos = await (await fetch('./db/productos.json')).json();

    let inCarrito = false;
    for (let j = 0; j < carrito.length; j++) {
        if (carrito[j].nombre == productos[j].nombre) {
            carrito[j].cantidad += 1;
            inCarrito = true;
        }
    }

    if (!inCarrito) {
        productos[i].cantidad = 1;
        carrito.push(productos[i]);
    }

    localStorage.setItem('cart', JSON.stringify(carrito));
    console.log(localStorage.getItem('cart'));
}