
var info = {};
var tables = ['transporte','relacion','pais','motivos','lenguaje','frec_visita','estado','escolaridad','comunicacion'];

function fetchData(query){

    let diccionario = {
        'estado':{title:'Estado',table:'estado'},
        'sexo':{title:'Sexo',table:''},
        'edad':{title:'Edad',table:''},
        'residencia':{title:'Pais de residencia',table:'pais'},
        'nacionalidad':{title:'Nacionalidad',table:'pais'},
        'escolaridad':{title:'Estudios',table:'escolaridad'},
        'estado_escolar':{title:'Grado',table:''},
        'primera_leng':{title:'1ra Lengua',table:'lenguaje'},
        'segunda_leng':{title:'2da Lengua',table:'lenguaje'},
        'frecuencia_visita':{title:'Frecuencia',table:'frec_visita'},
        'medio_com':{title:'Medio de Comunicacion',table:'comunicacion'},
        'motivo':{title:'Motivo de Visita',table:'motivos'},
        'medio_transporte':{title:'Medio de Transporte',table:'transporte'},
        'tiempo_traslado':{title:'Tiempo de Traslado',table:''},
        'tipo_grupo':{title:'Tipo de Acompañantes',table:'relacion'},
        'tamaño_grupo':{title:'Tamaño del Grupo',table:''},
        'menores_grupo':{title:'Menores de 12 en el grupo',table:''},
        'duracion':{title:'Duración de visita [min]',table:''},
    }

    $('#resumen').addClass('hidden');

    let resumen = {
        "nac":0,
        "ext":0,
        "lang":{},
    };

    $.ajax({
        url:"./assets/php/select.php",
        type:"post",
        dataType:"json",
        data:{
            "query":query
        },
        success:(datos)=>{
            let header = "";
            Object.keys(diccionario).forEach(k=>{
                header+="<th>"+diccionario[k]['title']+"</th>";
            });
            $('#thead').html(header);  
            let lineas = [];
            for(let i = 0; i < datos.length; i++){
                let html = "";
                html += "<tr>"
                Object.keys(diccionario).forEach(k=>{
                    if(diccionario[k]['table'] != ''){
                        html+="<td>"+info[diccionario[k]['table']][datos[i][k]]+"</td>";
                    }else{
                        html+="<td>"+datos[i][k]+"</td>";
                    }
                });
                if (datos[i]['nacionalidad'] == 15){
                    resumen['nac']++;
                }else{
                    resumen['ext']++;
                }

                resumen['lang'][datos[i]['primera_leng']] = resumen['lang'][datos[i]['primera_leng']] || 0;
                resumen['lang'][datos[i]['segunda_leng']] = resumen['lang'][datos[i]['segunda_leng']] || 0;
                resumen['lang'][datos[i]['primera_leng']]++;
                resumen['lang'][datos[i]['segunda_leng']]++;

                html += "</tr>";

                lineas.push(html);
 
            }
            if(datos.length > 0){
                $('#resumen').removeClass('hidden');
            }

            let langs = { 'k':0,'v':0};
        
            delete resumen['lang'][""];
            for(let j = 1; j < 3; j++){
                langs = { 'k':0,'v':0}
                Object.keys(resumen['lang']).forEach(l=>{
                    if(langs['v'] < resumen['lang'][l]){
                        langs['k'] = l;
                        langs['v'] = resumen['lang'][l];
                    }
                });
                $('#lang'+j).html(info[diccionario['primera_leng']['table']][langs['k']]);
                delete resumen['lang'][langs['k']];
            }
        
            $('#vis').html(datos.length);
            $('#nac').html(resumen['nac']);
            $('#ext').html(resumen['ext']);
            $('#tbody').html(lineas.join(''));  
        },
        error: (err)=>{
            console.error(err);
        }
    });
}

function toggleFilters(){
    if($('#filter-icon').hasClass('fa-caret-down')){
        $('#filter-icon').removeClass('fa-caret-down');
        $('#filter-icon').addClass('fa-caret-right');
        $('#filters').addClass('hidden');
    }else{
        $('#filter-icon').removeClass('fa-caret-right');
        $('#filter-icon').addClass('fa-caret-down');
        $('#filters').removeClass('hidden');
    }
}

function startingData(){


    tables.forEach(table => {
        $.ajax({
            url:"./assets/php/select.php",
            type:"post",
            dataType:"json",
            data:{
                "query":"select * from "+table+";"
            },
            success:(datos)=>{

                let data = {};
                let keys = Object.keys(datos[0]);
                
                opciones = ['<option selected value="">Todos</option>'];
                datos.forEach(d => {
                    data[d.ID] = d[keys[1]];
                    opciones.push('<option value="'+d.ID+'">'+d[keys[1]]+'</option>');
                });
                $('#sel-'+table).html(opciones.join(''));

                if(table == 'pais'){
                    $('#sel-nacionalidad').html(opciones.join(''));
                }


                info[table] = data;  
            },
            error: (err)=>{
                console.error(err);
            }
        });
    });
    console.log(info);
}

startingData();

function buscar(){
    let query = "select * from visitas where 1=1 ";

    let diccionario = {
        'transporte':'medio_transporte',
        'relacion':'tipo_grupo',
        'pais':'residencia',
        'motivos':'motivo',
        'lenguaje':'primera_leng',
        'frec_visita':'frecuencia_visita',
        'estado':'estado',
        'escolaridad':'escolaridad',
        'comunicacion':'medio_com'
    };

    tables.forEach(table => {
        switch(table){
            case 'pais':
                if($('#sel-'+table).val() != ''){
                    query += " and "+diccionario[table]+" = "+$('#sel-'+table).val();
                }
                if($('#sel-nacionalidad').val() != ''){
                    query += " and nacionalidad = "+$('#sel-nacionalidad').val();
                }
            break;
            case 'lenguaje':
                if($('#sel-'+table).val() != ''){
                    query += " and (primera_leng = "+$('#sel-'+table).val()+" or segunda_leng = "+$('#sel-'+table).val()+")";
                }
            break;
            default:
                if($('#sel-'+table).val() != ''){
                    query += " and "+diccionario[table]+" = "+$('#sel-'+table).val();
                }
            break;
        }
    });
    if($('#sel-estado-escolar').val() != ''){
        query += " and estado_escolar = '"+$('#sel-estado-escolar').val()+"'";
    }



    //console.log(query);
    fetchData(query);
}
