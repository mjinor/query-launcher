<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                @if($errors->any())
                <div style="margin-bottom: 5px;" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $errors->first() }}</span>

                </div>
                @endif
                <form x-data="{ query_name : '{{old('query_name')}}' }" method="GET" action="{{ route('execute') }}">
                    <div>
                        <x-jet-label for="query" value="{{ __('Query') }}" />
                        <select x-model="query_name" name="query_name" type="text" required id="query" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Select Query ...</option>
                            @foreach($query_struct as $class => $methods)
                                @foreach($methods as $method => $details)
                                    <option value="{{$class}}.{{$method}}">{{ __($details["show_as"]) }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    @foreach($query_struct as $class => $methods)
                        @foreach($methods as $method => $details)
                            @php
                            $n = 1;
                            $sorted_params = array_values(\Illuminate\Support\Arr::sort($details["params"], function ($value) { return $value['priority']; }));
                            @endphp
                            @foreach($details["params"] as $param)
                                <div class="mt-4">
                                    <x-jet-label x-show="query_name == '{{$class}}.{{$method}}'" for="{{$param['name']}}" value="{{ __($param['label']) }}" />
                                    <x-jet-input value="{{ old($method.'_param'.$n) }}" x-show="query_name == '{{$class}}.{{$method}}'" id="{{$param['name']}}" class="block mt-1 w-full" type="{{$param['type']}}" name="{{$method}}_param.{{$n}}" />
                                </div>
                                @php
                                    $n++;
                                @endphp
                            @endforeach
                        @endforeach
                    @endforeach
                    <div class="flex items-center justify-end mt-4">
                        <x-jet-button class="ml-4">
                            {{ __('Execute') }}
                        </x-jet-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
