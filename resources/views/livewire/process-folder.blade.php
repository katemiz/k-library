<section class="section container">

    <div class="buttons">
        <a class="button" href="/process-files/img">
            Images

        </a>
    </div>


    @isset($eklenenler)

    @foreach ($eklenenler as $eklenen)

        {{$eklenen}}

    @endforeach

    @endisset

    <table class="table is-fullwidth">
    @foreach ($dosyalar as $key => $dosya)


    <tr>
        <td>{{++$key}}</td>
        <td>{{$dosya['name']}}</td>
        <td>{{$dosya['size']}}</td>
        <td>
            @isset($dosya['thumbnail'])
                <img src="{{ $dosya['thumbnail'] }}">
            @endisset
        </td>

        <td>
            @isset($dosya['exif'])
                {{ print_r($dosya['exif']) }}
            @endisset
        </td>

        <td><a href="">Movie</a></td>
    </tr>

    @endforeach
    </table>

    @foreach ($directories as $dir)

    <p>{{$dir}}</p>

    @endforeach
</section>
