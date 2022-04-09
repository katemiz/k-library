export const pageprops = {

    page:{
        title:"Roles",
        subtitle:false,
        type:false,
    },


    description:`It is concerned with managing an entire production or service system which is the process 
        that converts inputs (in the forms of raw materials, labor, consumers, and energy) into outputs (in the form of goods 
        and/or services for consumers).[2] Operations produce products, manage quality and create services. 
        Operation management covers sectors like banking systems, hospitals, companies, working with suppliers,
        customers, and using technology. Operations is one of the major functions in an organization along with
        supply chains, marketing, finance and human resources. The operations function requires management of both
        the strategic and day-to-day production of goods and services`,

    image:'roles.svg',

    headers: {
        index:"Welcome",
        list:"List of Roles",
        show:"Role Properties",
    },


    table:{
        filter:{
            placeholder:"Search in roles ..."
        }
    },

    commands:{
        add:{
          label:"Add Role"
        }
    }
}


export const categoryprops = {
  
  titleColumn:"title_en",
  expanded:false,
  title:"Business Category",
  boxTitle:"My Tree",
  home:"My First Node title",
  filter_placeholder:"Search in tree ...",

  commands:{
    add:false
  }
}

export const formprops = {

  headers: {
    new: 'New Role Properties',
    update:'Update Properties',
    addlang:"Foreign Languages"
  },

  category:{
    id:"catId",
    label:"Business Category",
    placeholder:false
  },

  title_en:{
    id:"titleEN",
    label:"Role Definition/Title (EN)",
    placeholder:'Enter role title/definition'
  },

  title_tr:{
    id:"titleTR",
    label:"Rol/Unvan Adı (TR)",
    placeholder:'Rol/unvan tanımını giriniz ...'
  },

  editor_en:{
    id:"edEN",
    label:"Role Description, Details and Remarks",
    placeholder:'Type skill description ...'
  },

  editor_tr:{
    id:"edTR",
    label:"Rol/Unvan Ayrıntılar, Notlar (TR)",
    placeholder:'Rol tanımlamasını giriniz ...'     
  },

  editor_experience:{
    id:"edEx",
    label:"Experience and Areas of Work",
    placeholder:'Describe experience required ...'     
  },

  submit :{
    new :{
      label:"Create Role"
    },

    update:{
      label:"Update Role"
    }
  }

}


export const diplomaOptions = [
  {id:1,title:"Required"},
  {id:2,title:"Nice to have"}
]


export const professionCriteria = [
  {id:1,title:"Preferred"},
  {id:2,title:"Second options"},
  {id:3,title:"subject to other criteria"}
]