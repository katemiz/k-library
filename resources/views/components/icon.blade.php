<svg
    xmlns="http://www.w3.org/2000/svg"
    width="{{ $width ? $width : '24' }}"
    height="{{ $height ? $height : '24'}}"
    viewBox="0 0 24 24"
    fill="{{ $fill }}">
    @includeIf("icons.$icon")
</svg>
