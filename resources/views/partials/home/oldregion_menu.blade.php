<div id="region-menu">
    <ul>
        @foreach($regions as $region)
            <li>
                <a href="#" onclick="selectRegion('{{ $region->id }}')">111{{ $region->description }}</a>
            </li>
        @endforeach
    </ul>
</div>


<script>
    function selectRegion(regionId) {
        // Lógica para selecionar a região
        console.log("Região selecionada: " + regionId);
    }
</script>
