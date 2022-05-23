let arrbutton = document.getElementsByClassName('drgn');
for (i = 0; i < arrbutton.length; i++) {
    arrbutton[i].addEventListener('click', function (event) {
        ajax(event.target)
    })
}

function ajax(element) {
    // console.log(element.id)
    let btnId = element.id;
    let btnVal = element.value;
    let newUrl = '/';

    switch (btnVal) {
        case 'minus':
            newUrl += 'minus/';
            //when minus/ is called, the function in the CartController -> minus()  is being activated which then removes 1 or multiple
            //from the product total.
            break;
        case 'plus':
            newUrl += 'drum/';
            //when drum/ is called, the function in the CartController -> add()  is being activated which then adds 1 or multiple
            //from the product total.
            break;
    }

    newUrl += btnId

    // console.log(newUrl)
    fetch(newUrl, {
        method: 'GET', //haal de response op die word verstuurd wanneer een van de 2 bovenstaande cases wordt behaald.
    }).then(function (response) {
        return response.json()//als er data wordt terug gestuurd uit 1 van de 2 functies uit de CartController
    }).then(function (data) {//vervang de huidige html met de juiste waarde.
        if (typeof data.products[btnId] == 'undefined') {
            document.getElementById('prodcard' + btnId).remove();
        } else {
            document.getElementById('amount' + btnId).innerHTML = data.products[btnId].amount;
        }
        document.getElementById('total').innerText = data.total
    })
}




