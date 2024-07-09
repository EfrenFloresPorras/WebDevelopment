var datos = [];
async function load(){
    datos = await (await fetch('select.php')).json();

    let header = "";
    Object.keys(datos[0]).forEach(k=>{
        header+="<th>"+k+"</th>";
    });
    $('#thead').html(header);

    let body = "";
    datos.forEach(d=>{
        body+="<tr>";
        Object.values(d).forEach(v=>{
            body+="<td>"+v+"</td>";
        });
        body+="</tr>";
    });
    $('#tbody').html(body);
}

load();