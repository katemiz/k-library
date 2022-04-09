
/**
* Function that converts flat array into treeview object
* @param    {Array} dataArray       Name of data array of objects
* @return   {Object}                Tree Object with children
*/

export function unflatten(dataArray) {

    /*
        dataArray format
        [
            {"id":1,"title":"Title 1","other_props":"Other Props 1","parent_id":0},
            {"id":2,"title":"Title 2","other_props":"Other Props 2","parent_id":1},
            {"id":3,"title":"Title 3","other_props":"Other Props 3","parent_id":2}
        ]

        returns
        {
            "id": 1,
            "title": "Title 1",
            "other_props":"Other Props 1",
            "parent_id": 0,
            "children": [
                {
                    "id": 2,
                    "title": "Title 2",
                    "description": "Other Props 2",
                    "parent_id": 1,
                    "children": [
                        {
                            "id": 3,
                            "title": "Title 3",
                            "description": "Other Props 3",
                            "parent_id": 2,
                            "children": []
                        }
                    ]
                }
            ]
        }
    */

    const tree = []
    let mappedArr = {}
    let arrElem
    let mappedElem;

    // First map the nodes of the array to an object -> create a hash table.
    for(var i = 0, len = dataArray.length; i < len; i++) {
        arrElem = dataArray[i];
        arrElem.expanded = tree.expanded
        mappedArr[arrElem.id] = arrElem;
        mappedArr[arrElem.id]['children'] = [];
    }

    for (var id in mappedArr) {

        if (mappedArr.hasOwnProperty(id)) {

            mappedElem = mappedArr[id];

            // If the element is not at the root level, add it to its parent array of children.
            if (mappedElem.parent_id != 0) {

                // Get parent el level
                mappedElem.level = mappedArr[mappedElem['parent_id']].level+1
                mappedArr[mappedElem['parent_id']]['children'].push(mappedElem);
                
            }  else {
                mappedElem.level = 0
                tree.push(mappedElem);
            }
        }
    }

    return tree;
}




/**
* Function that converts parent-child array into line-by-line printable ordered array
* @param    {Array} parentChildArray        Name of parent-child array having objects as branches
* @return   {Array}                         Ordered flat array having objects as branches
*/


export function printOrder(parentChildArray,sonuc = []) {

    parentChildArray.forEach( el => {

        sonuc.push(el)

        if (el.children.length > 0) {
            printOrder(el.children,sonuc)
        }
    })

    return sonuc
}





/**
* Function that converts nested array of objects into flat array (with children)
* @param    {Array} array        Nested array of objects
* @return   {Array} array        flat array
*/

export function flat(array) {
    var result = [];
    array.forEach(function (a) {
        result.push(a);
        if (Array.isArray(a.children)) {
            result = result.concat(flat(a.children));
        }
    });
    return result;
  }


