@extends('partymeister-frontend::layouts.frontend')

@section('main_content')
    <h1>Stuff for sale at the Infodesk</h1>
    @foreach ($itemTypes as $itemType)
        <h3>{{$itemType->name}}</h3>
        @if ($itemType->items->count() > 0)
            <table class="table table-striped mb-5">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col" class="text-right">Price</th>
                </tr>
                </thead>
                <tbody>
            @foreach($itemType->items()->where('is_visible', true)->orderBy('sort_position', 'ASC')->get() as $item)
                <tr>
                    <td>
                        <strong>{{$item->name}}</strong>
                        <br>
                        {{$item->description}}
                    </td>
                    <td class="text-right">
                        <strong>{{number_format($item->price_with_vat, 2, ',', '.')}} &euro;</strong>
                    </td>
                </tr>
            @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
@endsection
