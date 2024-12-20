const container = document.querySelector('.seat-container');

var seats = [];
var total;

var myVariable = "Hello World!";

function toggle(seatsID) {
    var a = seats.indexOf(seatsID);
    if (a == -1) {
        add(seatsID);
    } else {
        cancle(seatsID);
    }
}

function add(seatsID) {
    var a = seats.push(seatsID);
    updateSelectedSeat();
}

function cancle(seatsID) {
    var a = seats.indexOf(seatsID);
    seats.splice(a,1);
    updateSelectedSeat();
}

function updateSelectedSeat() {
    var s = "";
    var total = 0;

    seats.sort();
    for (var x of seats) {
        s+=x+' ';

        var seatSelect = document.getElementById(x);
        var price = seatSelect.dataset.price;
        total = total + parseFloat(price);
    }
    
    document.getElementById('total').innerText = total;
    document.getElementById('selectSeats').innerText=s;

    document.cookie = 'total='+total ;
    document.getElementById('book-submit').value=seats;
}


container.addEventListener('click', (e) => {
    if (e.target.classList.contains('seat') && !e.target.classList.contains('seat-sold')) {
      e.target.classList.toggle('selected');
        
    }
});


updateSelectedSeat()

