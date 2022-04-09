
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

    <h1 class="title my-6 has-text-weight-light is-size-1 has-text-left">Competency / Skill Management</h1>

    <p class="mb-3">
    Competency is a set of skills, related knowledge and attributes that allow an individual to perform a task or an activity within a specific function or job. Therefore it is important for the success of the Organization in achieving its strategic goals, as well as the success of individual employee. Any function in the Organization requires a set of essential managerial/generic and technical/functional competencies to be performed effectively.
    </p>






    <x-icons name="user" size='XXL' color="danger"/>
    <x-icons name="home" size='XXL' color="danger"/>
    <x-icons name="skill" size='XXL' color="danger"/>
    <x-icons name="sign-up" size='XXL' color="danger"/>






    <div class="columns">

        <div class="column is-half">



            <p class="mb-3">
            It is crucial to link competencies with the strategic objectives, plans and capabilities of the Organization. Thus, competencies will increasingly be used as a basis for identifying individual and organizational needs and planning for development.</p>

            <p class="mb-3">
            Competency or skill management focusing on using the employee potential effectively to develop the necessary competencies and skills in order to run the organization smoothly and optimize the potential for profit and growth.</p>

            <p class="mb-3">
            With the help of proper skill management techniques, it is possible to combine project management and human resource management in an effective and efficient manner. The active management of competency and skill portfolio ensures the long-term competitiveness of company. </p>

        </div>

        <div class="column is-half">
            <figure class="image is-1by1">
                <img src="images/MindMap.svg" alt="The Process Flow" on:click="{showImg}">
            </figure>
        </div>

    </div>





    <div class="columns">
        <div class="column is-half">
            <figure class="image is-1by1">
                <img src="images/ProcessFlow.svg" alt="The Process Flow" on:click="{showImg}">
            </figure>
        </div>

        <div class="column is-half">

            <h3 class="subtitle has-text-weight-light is-size-3 has-text-left">Process Flow</h3>

            <details class="p-2">
                <summary class="has-text-info">1. Body of Knowledge</summary>
                <p class="ml-2 p-2">
                What should a person know and be able to demonstrate?
                </p>
            </details>

            <details class="p-2">
                <summary class="has-text-info">2. Assessment</summary>
                <p class="ml-2 p-2">
                Does the person understand and apply it?
                </p>
            </details>

            <details class="p-2">
                <summary class="has-text-info">3. Training</summary>
                <p class="ml-2 p-2">
                if not: What kinds of training can fill the gap?
                </p>
            </details>

            <details class="p-2">
                <summary class="has-text-info">4. Qualification</summary>
                <p class="ml-2 p-2">
                How do we demonstrate a person’s ability to fulfill specified requirements?
                </p>
            </details>

            <details class="p-2">
                <summary class="has-text-info">5. Maintain</summary>
                <p class="ml-2 p-2">
                How do we maintain both:
                </p>
                <ul class="ml-2 p-2">
                    <li>The process, to ensure the Body of Knowledge remains topical and relevant</li>
                    <li>The Qualification of the person.</li>
                </ul>
            </details>

        </div>
    </div>



    <h1 class="title my-6 has-text-weight-light is-size-1 has-text-left">Skill Matrix</h1>

    <p class="mb-3">
    The Skill Matrix is a technique to record and analyse the skills and competencies of all the employees of an organization. It is a mapping between skills and employees based on a knowledge function.</p>

    <p class="mb-3">

    The objectives of the skill matrix:.</p>

    <div class="content">
    <ul>

        <li>To define a relation between user and his/her skills </li>
        <li>To align skill and competency development with business goals</li>
        <li>To identify critical skills</li>
        <li>To find the right employee for a specific task or project</li>
        <li>To develop and enhance employees skills</li>
        <li>To assist establishment of flexible project teams</li>
        <li>To support accomplishing strategic objectives through managerial and technical skills upgrading</li>
        <li>To support exploring the employees future career path</li>

    </ul>
    </div>




    <div class="modal" id="imgModal">
        <div class="modal-background " on:click={closeModal}></div>
        <div class="modal-content has-background-light">
          <p class="image">
            <img src="" alt="Greet descriptions" id="modalImg">
          </p>
        </div>
        <button class="modal-close is-large" aria-label="close"  on:click={closeModal}></button>
      </div>

</section>