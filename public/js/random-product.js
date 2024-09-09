let intervalId

function truncateText (text, maxLength) {
  return text.length > maxLength ? text.substring(0, maxLength) + '...' : text
}

function displayRandomProduct () {
  const currentRoute = document.getElementById('main-list').getAttribute('data-route');
  const currentLocale = document.getElementById('main-list').getAttribute('data-locale');
  if (currentRoute === 'app_home') {
    fetch(`/${currentLocale}/random-product`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('product-name').innerText = data.name
        document.getElementById('product-description').innerText = truncateText(
          data.description,
          20
        )
        document.getElementById('product-price').innerText = `${data.price} DT`

        const imagePath = '/uploads/images/' + data.image
        document.getElementById('product-image').src = imagePath

        const productLink = `/${currentLocale}/product/` + data.id + '/show'
        document.getElementById('product-link').href = productLink

        const card = document.getElementById('random-product-card')

        card.style.display = 'block'
        setTimeout(() => {
          card.style.opacity = 1
        }, 10)

        setTimeout(() => {
          card.style.opacity = 0
          setTimeout(() => {
            card.style.display = 'none'
          }, 500)
        }, 5000)
      })
  }
}

if (!intervalId) {
  intervalId = setInterval(displayRandomProduct, 30000)
}

window.addEventListener('beforeunload', () => {
  if (intervalId) {
    clearInterval(intervalId)
  }
})
