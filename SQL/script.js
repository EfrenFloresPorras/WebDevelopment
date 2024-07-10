function fetchData() {
    const query = $("#query").val().trim();

    if (query.length === 0) {
        alert("Please enter a MySQL query");
        return;
    }

    $.ajax({
        url: "select.php",
        type: "post",
        dataType: "json",
        data: { "query": query },
        success: (response) => {
            console.log(response);
            loadData(response);
        },
        error: (err) => {
            console.error("Error fetching data:", err);
            alert("An error occurred while fetching data. Please check the console for details.");
        }
    });
}

function loadData(data) {
    if (!Array.isArray(data) || data.length === 0) {
        alert("No data returned from the query");
        return;
    }

    let header = "";
    Object.keys(data[0]).forEach(k => {
        header += "<th>" + k + "</th>";
    });
    $('#thead').html(header);

    let body = "";
    data.forEach(row => {
        body += "<tr>";
        Object.values(row).forEach(val => {
            body += "<td>" + val + "</td>";
        });
        body += "</tr>";
    });
    $('#tbody').html(body);
}

// Remove the initial load() call as we'll fetch data only when the button is clicked