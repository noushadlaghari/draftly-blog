async function request(url,data){

    try{

        let response = await fetch(url,{
            method: "POST",
            body: data
        });
        

        let raw = await response.text();

        if(!response.ok){
            console.log("Request Error: ",response.status, raw);
            showMessage("danger", "Failed to Data! Please Try Again.");
            throw new Error();
        }

        try{
            return JSON.parse(data);
        }catch (e){
            return response.text();
        }

       
    }catch(e){

        showMessage("danger","Failed to Fetch Data!");
        console.log("Request Error: ",e)

    }



}

function showMessage(type,message){
    let message = document.getElementById("message");

    message.innerHTML = `
         <div class="alert alert-${type} alert-dismissible fade show" role="alert">
             ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    setTimeout(()=>{
        message.innerHTML = "";
    },2500)
}