    let paroleSuggerite = [];

    const suggestedDiv = document.getElementById("suggestion");

    function sendText() {
    var ajaxRequest;
    let text = document.getElementById("txtId").value;
    //console.log({ testo : text });
    ajaxRequest= $.ajax({
            url: 'http://localhost:8080/Test/Be/listener.php',
            type: 'POST',
            data: { testo : text },
            dataType : 'json',
            success :  function (response) {
                //$("#result").html(response.Items.join(", "));

                response.Items.forEach(element => {
                    
                    if(!paroleSuggerite.includes(element)){
                        paroleSuggerite.push(element);
                    }
                });
                
                changeList();

                paroleSuggerite = [];
                
            }
        });
    }

    function changeList(){
        $(suggestedDiv).empty();
        paroleSuggerite.forEach(parola => {
                    
            const div = document.createElement("option");
            div.value = parola;
            
            suggestedDiv.appendChild(div);
        });
    }