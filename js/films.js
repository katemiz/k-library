import { Tabulator, Greeter } from './tabulator.js'
import {Icon} from '../../Common/js/Icon.js'


document.addEventListener('DOMContentLoaded', () => {

    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach( el => {

            el.addEventListener('click', () => {

                // Get the target from the "data-target" attribute
                const target = el.dataset.target;
                const $target = document.getElementById(target);

                // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                el.classList.toggle('is-active');
                $target.classList.toggle('is-active');
            });
        });
    }
});



let i = new Icon(iconpaths)

Greet();


// BINDINGS

// SEARCH BUTTON
let searchButton = document.getElementById('search_button');
searchButton.innerHTML = i.Icon("search","S","light")
searchButton.addEventListener('click', () => Search());

// TOP LINKS
let topLink1 = document.getElementById("topLink1")
topLink1.innerHTML = i.Icon("movie","S","light")+'All Movies'
topLink1.addEventListener('click', () => ShowAll());

let topLink2 = document.getElementById("topLink2")
topLink2.innerHTML = i.Icon("refresh","S","light")+'Refresh'
topLink2.addEventListener('click', () => RefreshAll());

let topLink3 = document.getElementById("topLink3")
topLink3.innerHTML = i.Icon("add","S","light")+'Add'
topLink3.addEventListener('click', () => ListNew());








function Greet() {

    fetch('/Films/api/api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action:"listall",
            showRandom:true,
            noResults:3
        })
    })
    .then(response => response.json())
    .then((response) => {

        let options = {
            parentElId:'arena',
            tableHeader:"List of All Films",
            itemsPerPage:5,
        }
    
        new Greeter(response.films,options)
    })
    .catch(err => console.error(err));
}


function ShowAll() {

    fetch('/Films/api/api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action:'listall',
            showRandom:false
        })
    })
    .then(response => response.json())
    .then((response) => {

        let options = {
            parentElId:'arena',
            tableHeader:"List of All Films",
            itemsPerPage:5,
        }
    
        document.getElementById("arena").innerHTML = ''

        let tablo = new Tabulator(response.films,options)
        tablo.setElements()

    })
    .catch(err => console.error(err));

}


function Search() {

    let elValue = document.getElementById("query").value

    if (elValue.length < 3) {
        return true
    }

    let params = {
        action:'search',
        query:elValue
    }

    fetch('/Films/api/api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
    })
    .then(response => response.json())
    .then((response) => {

        let options = {
            parentElId:'arena',
            tableHeader:"Search Results",
            itemsPerPage:10,
        }

        document.getElementById("arena").innerHTML = ''

        if (response.films.length > 0) {
            let arama = new Tabulator(response.films,options)
            arama.setElements ()
        } else {
            document.getElementById("arena").innerHTML =`
            <div class="notification is-warning">
            No resuts found matching the query criteria
            </div>`
        }
    })
    .catch(err => console.error(err));
}


function ListNew () {

    fetch('/Films/api/api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({action:'listNew'})
    })
    .then(response => response.json())
    .then((response) => {

        if (response.files.length > 0) {

            document.getElementById("arena").innerHTML = ''

            let tablo = document.createElement("table")
            tablo.classList.add("table","is-fullwidth")

            let tr_head = document.createElement("tr")
            tr_head.innerHTML = '<th>Name</th><th>Size</th><th>Type</th><th>Action</th>'

            tablo.append(tr_head)
            document.getElementById("arena").append(tablo)

            let tr,td_a,td_b,td_c,td_d,act

            response.files.forEach(dosya => {

                tr = document.createElement("tr")
                td_a = document.createElement("td")
                td_a.innerHTML = dosya.name

                td_b = document.createElement("td")
                td_b.innerHTML = dosya.size

                td_c = document.createElement("td")
                td_c.innerHTML = dosya.type

                td_d = document.createElement("td")

                act = document.createElement("a")
                act.innerHTML = 'Add'

                tr.append(td_a)
                tr.append(td_b)
                tr.append(td_c)
                tr.append(td_d)
                td_d.append(act)

                tablo.append(tr)

                act.addEventListener("click", () => showAddModal(dosya.name))
            })
        } else {
            document.getElementById("arena").innerHTML = 'No files to list'
        }
    })
    .catch(err => console.error(err));   
}

function hideAddModal() {

    document.getElementById("addmodal").classList.remove("is-active")

}

function showAddModal(filename) {


    document.getElementById("mod111").addEventListener("click", () => hideAddModal())
    document.getElementById("mod112").addEventListener("click", () => hideAddModal())
    document.getElementById("mod113").addEventListener("click", () => hideAddModal())



    document.getElementById("addmodal").classList.add("is-active")
    document.getElementById("newfilename").innerHTML = filename

    let btn = document.getElementById("continueButton")
    btn.addEventListener("click", () => InsertIntoDb(filename,document.getElementById("imdbNo").value))
}



function InsertIntoDb(filename,imdbNo) {
    
    fetch('/Films/api/api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action:'insertNewFilm',
            filename:filename,
            imdb:imdbNo
        })
    })
    .then(response => response.json())
    .then((response) => {

        if (!response.error) {

            hideAddModal()
            Swal.fire('Successfully added')
            ListNew ()
        }
    })
    .catch(err => console.error(err));
}


function RefreshAll() {


    fetch('/Films/api/api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({action:'scanAll'})
    })
    .then(response => response.json())
    .then((response) => {


    })
    .catch(err => console.error(err));



}