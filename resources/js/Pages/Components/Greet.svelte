<script>

    function showImg(el) {

        console.log(el.target)
        document.getElementById('modalImg').src = el.target.src        
        document.getElementById('imgModal').classList.add('is-active')
    }

    function closeModal() {
        document.getElementById('imgModal').classList.remove('is-active')
    }

</script>


<section class="section container">

    <h1 class="title my-6 has-text-weight-light is-size-1 has-text-left">Personal Digital Library</h1>

    <p class="mb-3">
    Competency is a set of skills, related knowledge and attributes that allow an individual to perform a task or an activity within a specific function or job. Therefore it is important for the success of the Organization in achieving its strategic goals, as well as the success of individual employee. Any function in the Organization requires a set of essential managerial/generic and technical/functional competencies to be performed effectively.
    </p>


    <div class="columns">

        <div class="column  is-half">

            <div class="content">
                <ul>
                    <li>Books</li>
                    <li>Videos</li>
                    <li>Images</li>
                    <li>Any file that you can think of</li>
                </ul>
            </div>
            
        </div>

        <div class="column is-half">
            <figure class="image is-1by1">
                <img src="images/assets.svg" alt="assets" on:click="{showImg}">
            </figure>
        </div>

    </div>

</section>


<!-- MODAL -->

<div class="modal" id="imgModal">
    <div class="modal-background " on:click={closeModal}></div>
    <div class="modal-content has-background-light">
        <p class="image"><img src="" alt="assets" id="modalImg"></p>
    </div>
    <button class="modal-close is-large" aria-label="close"  on:click={closeModal}></button>
</div>