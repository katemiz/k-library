<script>

    import {Colors} from '../../Definitions/Colors'
    import {Sizes} from '../../Definitions/Sizes'
    import {SVGS} from '../../Definitions/Svgs'

    export let name
    export let size
    export let color

    let boyut,renk,path

    if (size != null && size != undefined) {
        boyut = Sizes[size]
    } else {
        boyut = Sizes["XS"]
    }

    if (color != null && color != undefined) {
        renk = Colors[color]
    } else {
        renk = Colors["black"]
    }

    if (name != null && name != undefined) {
        path = SVGS[name]
    } else {
        path = SVGS["home"]
    }

    let svg = `
    <svg
        xmlns="http://www.w3.org/2000/svg"
        height="${boyut}"
        viewBox="0 0 24 24"
        width="${boyut}"
        fill="${renk}">
        ${path}
    </svg>`

</script>

{@html svg}