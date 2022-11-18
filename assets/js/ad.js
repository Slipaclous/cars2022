
console.log('hello')
    const addImage = document.querySelector('#add_image')

    addImage.addEventListener('click',()=>{
    // compter combien j'ai de form-group pour les indices ex: annonce_image_0_url
    console.log('bisous')
    const widgetCounter = document.querySelector("#widgets-counter")
    const index = +widgetCounter.value // le + permet de transofmer en nombre, value rends tjrs un string 
    const annonceImages = document.querySelector('#voitures_images')

    //recup le prototype des entrées data-prototype
    const prototype = annonceImages.dataset.prototype.replace(/__name__/g, index) // drapeau g pour indiquer que l'on va le faire plusieurs fois 

    //injecter le code dans la div
    annonceImages.insertAdjacentHTML('beforeend', prototype)
    widgetCounter.value = index+1

    handleDeleteButtons() // pour mettre à jour le tablea deletes et ajouter l'évent 
})

const updateCounter = () => {
    const count = document.querySelectorAll('#voitures_images div.form-group').length
    document.querySelector('#widgets-counter').value = count
}

const handleDeleteButtons = () => {
    var deletes = document.querySelectorAll("button[data-action='delete']")

    deletes.forEach(button => {
        button.addEventListener('click',()=>{
            const target = button.dataset.target
            const elementTarget = document.querySelector(target)
            if(elementTarget){
                elementTarget.remove() // supprimer l'élément 
            }
        })
    })


}

updateCounter()
handleDeleteButtons()
