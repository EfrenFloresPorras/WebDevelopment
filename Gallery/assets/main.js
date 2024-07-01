document.addEventListener("DOMContentLoaded", () => {
    fetch("./assets/images.json", {cache: "no-store"})
    .then((response)=>response.json())
    .then((json) =>{
        const gallery = document.getElementById("gallery-container");

        json.forEach(img => {
            console.log(img);
            let div = document.createElement("DIV");
            div.classList.add("image-container");
            
            let image = document.createElement("IMG");
            image.src= img.src;
            div.appendChild(image);
            gallery.appendChild(div);
        });
    })
});