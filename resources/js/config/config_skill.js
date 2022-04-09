
export const pageprops = {

    page:{
        title:"Skills",
        subtitle:false,
        type:false,
    },

    headers: {
        index:"Welcome",
        list:"List of Roles",
        show:"Role Properties",
    },

    description: "On the left side of this dffmf",

    image:"skills.svg"


}




export const treeprops = {
  
  titleColumn:"title_en",
  expanded:false,
  title:"Skill",
  boxTitle:"My Tree",
  home:"My First Node title",
  filter_placeholder:"Search in tree ...",

  commands:{
    add:{
      label:"Add Skill"
    }
  }
}

export const formprops = {

  header: {
    new: 'Properties',
    update:'Update Properties'
  },

  parent:{
    id:"parentId",
    label:"Parent Skill",
    placeholder:false
  },

  title_en:{
    id:"titleEN",
    label:"Skill Definition/Title (EN)",
    placeholder:'Enter skill title/definition'
  },

  title_tr:{
    id:"titleTR",
    label:"Yetenek İsmi/Tanımı (TR)",
    placeholder:'Yetenek ismini/tanımını giriniz ...'
  },

  editor_en:{
    id:"edEN",
    label:"Skill Description (EN)",
    placeholder:'Type skill description ...'
  },

  editor_tr:{
    id:"edTR",
    label:"Yetenek Tanımlaması (TR)",
    placeholder:'Yetenek tanımlamasını giriniz ...'     
  },

  submit :{
    new :{
      label:"Create"
    },

    update:{
      label:"Update"
    }
  }

}



export let tableprops = {
  headers:[
    "Id",
    "Title",
    "Remarks",
    "Date",
    "Parent Id"
  ]
}



export const topnode = {
  id:0,
  title_en:'Top Node',
  title_tr:'Ana dal',
  level:0,
  children:[]
}



