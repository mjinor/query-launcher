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
                <form x-data="{ query_name : '{{old('query_name')}}',route : '' }" method="GET" x-bind:action="'/dashboard/query/' + query_name">
                    <div>
                        <x-jet-label for="query" value="{{ __('Query') }}" />
                        <select x-model="query_name" name="query_name" type="text" required id="query" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">{{ __("Select Query ...") }}</option>
                            @foreach($query_struct as $route => $details)
                                <option value="{{$route}}">{{ __($details["show_as"]) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @foreach($query_struct as $route => $details)
                        @foreach($details['params'] as $input)
                            <div class="mt-4">
                                <x-jet-label x-show="query_name == '{{$route}}'" for="{{$input['name']}}" value="{{ __($input['label']) }}" />
                                <x-jet-input x-bind:disabled="query_name != '{{$route}}'" value="{{ (empty(old($input['name'])))?@$input['value']:old($input['name']) }}" x-show="query_name == '{{$route}}'" id="{{$input['name']}}" class="block mt-1 w-full" type="{{$input['type']}}" name="{{$input['name']}}" />
                            </div>
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
