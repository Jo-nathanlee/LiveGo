TweenMax.set(".play-circle-01", {
    rotation: 90,
    transformOrigin: "center"
})

TweenMax.set(".play-circle-02", {
    rotation: -90,
    transformOrigin: "center"
})



const rotateTL = new TimelineMax({ paused: true })
    .to(".play-circle-01", .7, {
        opacity: .1,
        rotation: '+=360',
        strokeDasharray: "456 456",
        ease: Power1.easeInOut
    }, 0)
    .to(".play-circle-02", .7, {
        opacity: .1,
        rotation: '-=360',
        strokeDasharray: "411 411",
        ease: Power1.easeInOut
    }, 0)




const button = document.querySelector(".play-button")
const button2 = document.querySelector(".play-triangle")

button.addEventListener("mouseover", () => rotateTL.play())
button.addEventListener("mouseleave", () => rotateTL.reverse())

button2.addEventListener("mouseover", () => rotateTL.play())
button2.addEventListener("mouseleave", () => rotateTL.reverse())
