import {Icon} from '../../Common/js/Icon.js'

export class Tabulator {

    constructor(data,options) {

        this.icon = new Icon(iconpaths)

        if (options.itemsPerPage != undefined && options.itemsPerPage != null) {
            this.items_per_page = options.itemsPerPage
        } else {
            this.items_per_page = 10
        }

        if (options.tableHeader != undefined && options.tableHeader != null) {
            this.tableHeader = options.tableHeader
        } else {
            this.tableHeader = false
        }

        this.currentPage = 1
        this.parentElId = options.parentElId
        this.noTotalPages = Math.floor(data.length/this.items_per_page)
        this.noTotalItems = data.length
        this.data = data

        this.setModal()
    }


    setElements () {

        /* 
        <h1>Table Header</h1>
        <nav></nav>
        <div></div>
        <nav></nav>
        */

        if (this.tableHeader) {
            // Data Table Header
            document.getElementById(this.parentElId).append(this.setTableHeader())
        }

        if (this.noTotalPages > 1) {
            // Top Pagination
            document.getElementById(this.parentElId).append(this.setPageNav())
        }

        // Data Table View
        document.getElementById(this.parentElId).append(this.tabulate())

        if (this.noTotalPages > 1) {
            // Bottom Pagination
            document.getElementById(this.parentElId).append(this.setPageNav())
        }
    }


    setTableHeader() {

        let title = document.createElement("h1")
        title.classList.add('title','has-text-weight-light','has-text-centered','mb-6','is-size-3')
        title.innerHTML = this.tableHeader+` [${this.noTotalItems}]`

        return title
    }


    setPageNav () {

        /* 
        <nav class="pagination is-centered is-small my-4" role="navigation" aria-label="pagination">
            <a class="pagination-previous has-background-grey-lighter"></a>
            <a class="pagination-next has-background-grey-lighter"></a>
            <ul class="pagination-list"></ul>
        </nav>
        */

        let nav = document.createElement("nav")
        nav.classList.add('pagination','is-centered','is-small','my-4')
        
        let prevPage = document.createElement("a")
        prevPage.classList.add('pagination-previous','has-background-grey-lighter')
        prevPage.innerHTML = this.icon.Icon('previous','S','link')

        let nextPage = document.createElement("a")
        nextPage.classList.add('pagination-next','has-background-grey-lighter')
        nextPage.innerHTML = this.icon.Icon('next','S','link')

        let navUl = document.createElement("ul")
        navUl.classList.add('pagination-list')

        nav.append(prevPage)
        nav.append(nextPage)
        nav.append(navUl)

        prevPage.addEventListener("click", () => this.changePage("p"))
        nextPage.addEventListener("click", () => this.changePage("n"))

        this.pageNumbers(navUl)

        return nav
    }



    pageNumbers(ulEl) {

        let is_current
        let pageNumbers
    
        if (this.noTotalPages <= 9) {
    
            pageNumbers = [
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
            ]
    
        } else {
    
            if (this.currentPage >= 1 && this.currentPage <= 6 ) {
    
                pageNumbers = [
                    1,
                    2,
                    3,
                    4,
                    5,
                    6,
                    false,
                    this.noTotalPages-1,
                    this.noTotalPages,
                ]
            }
        
            if (this.currentPage > 6 && this.currentPage <= this.noTotalPages-6 ) {
        
                pageNumbers = [
                    1,
                    2,
                    false,
                    this.currentPage-2,
                    this.currentPage-1,
                    this.currentPage,
                    this.currentPage+1,
                    this.currentPage+2,
                    false,
                    this.noTotalPages-1,
                    this.noTotalPages,
                ]
            }
        
            if (this.currentPage > this.noTotalPages-6 && this.currentPage <= this.noTotalPages ) {
        
                pageNumbers = [
                    1,
                    2,
                    false,
                    this.noTotalPages-5,
                    this.noTotalPages-4,
                    this.noTotalPages-3,
                    this.noTotalPages-2,
                    this.noTotalPages-1,
                    this.noTotalPages,
                ]
            }
        }
        
        let li_a
    
        pageNumbers.forEach (el => {
    
            is_current = false
    
            if (this.currentPage == el) {
                is_current = 'is-current'
            }

            let liEl = document.createElement('li')
            ulEl.append(liEl)
    
            if (el) {

                li_a = document.createElement('a')
                li_a.classList.add('pagination-link')

                if (is_current) {
                    li_a.classList.add(is_current)
                }
                li_a.innerHTML = el

                liEl.append(li_a)
                li_a.addEventListener("click", () => this.changePage(el))
    
            } else {
                liEl.innerHTML = '<span class="pagination-ellipsis">&hellip;</span>'
            }
        }) 
    }
  


    changePage(clickedPageNo) {

        /* 
            clickedPageNo p    PreviousPage
            clickedPageNo n    NextPage
            clickedPageNo positiveNumber    goTo clicked page
        */

        document.getElementById(this.parentElId).innerHTML = ''
    
        let previousCurrentPage = this.currentPage
    
        switch (clickedPageNo) {
    
            case "p":    
                if (this.currentPage != 1) {
                    this.currentPage = this.currentPage-1
                }
                break
    
            case "n":    
                if (this.currentPage != this.noTotalPages) {
                    this.currentPage = this.currentPage+1
                }
                break      
                
            default:   
                this.currentPage = clickedPageNo
                break
        }
    
        if (this.currentPage != previousCurrentPage) {
            this.setElements()
        }
    }



    tabulate() {

        let tabloDiv = document.createElement("div")
        tabloDiv.classList.add("column")

        let start_key = (this.currentPage-1)*this.items_per_page+1
        let end_key = start_key+this.items_per_page
    
        let counter = 0
    
        let columnsEl   // One item container
        let imgColumn
        let contentColumn

        this.data.forEach(film => {
    
            counter++
    
            if (counter >= start_key && counter <end_key) {

                columnsEl = document.createElement("div")
                columnsEl.classList.add("columns","box")
                columnsEl.id = film.id

                imgColumn = document.createElement("div")
                imgColumn.classList.add("column","is-3")
                imgColumn.innerHTML = `<figure class="image is-9by16"><img src="${film.image}"></figure>`

                contentColumn = document.createElement("div")
                contentColumn.classList.add("column")

                let orgTitle = ''
                if (film.orgtitle !=null) {
                    orgTitle = `<p class="has-text-weight-light is-size-5 has-text-grey">${film.orgtitle}</p>`
                }

                contentColumn.innerHTML = `
                <p class="heading has-text-danger">${film.id} - ${film.year}</p>
                <p class="has-text-weight-light is-size-4">${film.title}</p>
                ${orgTitle}
                <p class="heading has-text-info">${film.directors}</p>
                <p class="heading has-text-grey">${film.folder}</p>`

                columnsEl.append(imgColumn)
                columnsEl.append(contentColumn)

                tabloDiv.append(columnsEl)

                columnsEl.addEventListener("click", () => this.showModal(film.id))
                columnsEl.addEventListener("mouseover", () => this.hilight(film.id))
                columnsEl.addEventListener("mouseleave", () => this.unhilight(film.id))
            }
        })

        return tabloDiv    
    }



    setModal () {

        let modal = document.createElement("div")
        modal.classList.add("modal")
        modal.id="modal"

        modal.innerHTML = `
        <div class="modal-background" id="modal_bground"></div>

        <div class="modal-content has-background-light">

            <div class="column is-8 is-offset-2">
                <figure class="image is-3by4">
                    <img src="" id="poster" alt="" >
                </figure>
            </div>

            <div class="column has-text-right">
                <input type="hidden" id="modalItemId" value="false">
                <button class="button" id="refreshDb">
                    <span class="icon is-small">${this.icon.Icon("refresh",'S','link')}</span>
                </button>
            </div>

            <div class="column p-3">
                <a id="filmTitle"></a>
                <div class="content" id="director"></div>
                <div class="content" id="filmPlot"></div>
                <div class="content" id="smbLink"></div>
            </div>        

            <div class="column">
                <table class="table is-fullwidth" id="filesTable">
                </table>
            </div>

        </div>
        <button class="modal-close is-large" id="closeBtn" aria-label="close"></button>`

        document.body.append(modal)

        document.getElementById("modal_bground").addEventListener("click", () => this.closeModal())
        document.getElementById("closeBtn").addEventListener("click", () => this.closeModal())
        document.getElementById("refreshDb").addEventListener("click", () => this.refreshDb())
    }



    hilight(id) {
        document.getElementById(id).classList.add("has-background-light")
    }



    unhilight(id) {
        document.getElementById(id).classList.remove("has-background-light")
    }



    showModal (filmId) {

        document.getElementById("modalItemId").value = filmId

        let imdb = 'https://www.imdb.com/title/'+filmId

        let selectedFilm = this.data.filter(el => el.id == filmId)[0]

        document.getElementById("filmTitle").innerHTML = selectedFilm.title
        document.getElementById("filmTitle").href = imdb

        document.getElementById("director").innerHTML = selectedFilm.directors

        document.getElementById("poster").src = selectedFilm.image
        document.getElementById("poster").alt = selectedFilm.title

        document.getElementById("filmPlot").innerHTML = ''

        if (selectedFilm.plot != null) {
            document.getElementById("filmPlot").innerHTML = selectedFilm.plot
        }
        
        this.scanDir(filmId)
        
        document.getElementById("filesTable").innerHTML=''
        document.getElementById("modal").classList.add("is-active")
    }



    scanDir (id) {

        fetch('/Films/api/api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({action:"scandir",id:id})
        })
        .then(response => response.json())
        .then((response) => {

            let row
            let fileCounter = 0

            response.files.forEach(file => {

                if (file.name != '.' && file.name !='..') {

                    // Table Row
                    row = document.createElement("tr")
                    row.id = id+fileCounter.toString()
                    row.innerHTML = `
                    <td><a href="/wd2tb/IMDB/${id}/${file.name}">${file.name}</a></td>
                    <td>${file.size}</td>
                    <td>${file.mime}</td>
                    <td><a id="anc${fileCounter.toString()}">${this.icon.Icon('delete','S','danger')}</a></td>`
                    
                    document.getElementById("filesTable").append(row)
                    document.getElementById("anc"+fileCounter.toString()).addEventListener("click",() => this.deleteFile(id,file.name,row.id))

                    fileCounter++
                }
            })
            
        })
        .catch(err => console.error(err));
    }



    closeModal () {
        document.getElementById("modal").classList.remove("is-active")
    }



    deleteFile(id,file,idRow) {

        let fileToDelete = `/wd2tb/IMDB/${id}/${file}`

        Swal.fire({
            title: 'Really delete file?',
            text: `${file} ; will be permanetly deleted!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if (result.isConfirmed) {

                fetch('/Films/api/api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({action:"deleteFile",file:fileToDelete})
                })
                .then(response => response.json())
                .then((response) => {
                    document.getElementById(idRow).remove()                    
                })
                .catch(err => console.error(err));
            }
        })
    }



    refreshDb() {

        let ttid    = document.getElementById("modalItemId").value

        fetch('/Films/api/api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action:"refreshDb",
                ttid:ttid
            })
        })
        .then(response => response.json())
        .then((response) => {

            if (response.error) {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed!',
                    footer: '<a href="">See console.log?</a>'
                })

                console.log(response)
            } else {
                Swal.fire('Successfully refreshed')
            }
        })
        .catch(err => console.error(err));
    }
    
}









export class Greeter extends Tabulator {

    constructor(data,options) {

        super(data,options)
        this.showRandom()
    }


    showRandom() {

        let torba = document.getElementById(this.parentElId)

        let header = document.createElement("h1")
        header.classList.add('title','has-text-weight-light','mt-6','is-size-3')
        header.innerHTML = 'Random Selections'
        torba.append(header)

        header.addEventListener("click", () => this.refreshGreet())

        let columns = document.createElement("div")
        columns.classList.add("columns")

        torba.append(columns)

        let singleCard

        this.data.forEach(film => {

            singleCard = document.createElement("div")
            singleCard.classList.add("column","card")
            singleCard.innerHTML = `
            <div class="card-image">
                <figure class="image is-3by4">
                    <img src="${film.image}" alt="${film.title}">
                </figure>
            </div>`

            columns.append(singleCard)
            singleCard.addEventListener("click", () => this.showModal(film.id))
        })
    }


    refreshGreet () {

        fetch('/Films/api/api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({noResults:3})
        })
        .then(response => response.json())
        .then((response) => {

            this.data = response.films
            document.getElementById(this.parentElId).innerHTML = ''    
            this.showRandom()        
        })
        .catch(err => console.error(err));
    }
}