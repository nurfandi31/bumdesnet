var choiceData = []

function setSelect(params = '.choices') {
    document.querySelectorAll(params).forEach(function (current_node, index) {
        var id = current_node.getAttribute('id');

        if (id) {
            console.log(id in choiceData, id);
            if (id in choiceData) {
                console.log(choiceData[id])
                choiceData[id].destroy();
            }

            if (current_node.classList.contains("multiple-remove")) {
                choiceData[id] = new Choices('#' + id, {
                    delimiter: ",",
                    editItems: true,
                    maxItemCount: -1,
                    removeItemButton: true,
                })
            } else {
                choiceData[id] = new Choices('#' + id)
            }
        }
    })
}

setSelect()
