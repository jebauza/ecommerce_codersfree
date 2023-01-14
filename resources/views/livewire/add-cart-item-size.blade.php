<div>
    <div>
        <p class="text-xl text-gray-700">Talla:</p>

        <select class="form-control w-full">
            <option value="" selected disabled>Selecione una talla</option>

            @foreach ($sizes as $size)
                <option value="{{ $size->id }}" selected disabled>{{ $size->name }}</option>
            @endforeach
        </select>
    </div>
</div>
