<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($success))
                <div style="text-align: center" class="bg-indigo-50 border border-indigo-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{$success}}</span>
                </div>
            @endif
            @if(isset($error))
                <div style="text-align: center" class="bg-indigo-50 border border-indigo-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{$error}}</span>
                </div>
            @endif
            @if(isset($result))
                @if(\Illuminate\Support\Facades\Config::get("query.mode") == \App\Http\Controllers\QueryController::DYNAMIC_MODE)
                    <div style="overflow-x:auto;">
                        <table class="table-fixed w-full">
                           <thead>
                                <tr class="bg-gray-100">
                                @foreach($columns as $column)
                                    <th class="px-4 py-2 w-20">{{ $column }}</th>
                                @endforeach
                                </tr>
                           </thead>
                            <tbody>
                            @foreach($result as $item)
                                <tr>
                                @foreach($columns as $column)
                                    <td class="border px-4 py-2">{{ $item->$column }}</td>
                                @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                @foreach($result as $table)
                    <div style="overflow-x:auto;">
                        <table class="table-fixed w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                @foreach($table["columns"] as $column)
                                    <th class="px-4 py-2 w-20">{{ $column }}</th>
                                @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($table["data"] as $item)
                                <tr>
                                    @foreach($table["columns"] as $column)
                                    <td class="border px-4 py-2">{{ $item->$column }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
                @endif
            @endif
        </div>
        <div class="flex items-center justify-center mt-4">
            <a href="{{route('dashboard')}}">
            <x-jet-button class="ml-4">
                {{ __('Return') }}
            </x-jet-button>
            </a>
        </div>
    </div>
</x-app-layout>
