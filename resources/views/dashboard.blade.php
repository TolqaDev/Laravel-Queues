<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <form method="POST" action="{{ route('jobs.send') }}">
            @csrf
            <div style="float: right;">
                <x-danger-button>
                    {{ __('Click To Send Mail') }}
                </x-danger-button>
            </div>
        </form>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">#Process ID</th>
                                <th scope="col" class="px-6 py-3">User Name</th>
                                <th scope="col" class="px-6 py-3">User Email</th>
                                <th scope="col" class="px-6 py-3">Created At</th>
                                <th scope="col" class="px-6 py-3">Process</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php  $jobsCount = 0; @endphp
                            @foreach ($jobsList as $job) @php $jobsCount++ @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">#{{$jobsCount}}</th>
                                <td class="px-6 py-4">{{$job->userName}}</td>
                                <td class="px-6 py-4">{{$job->email}}</td>
                                <td class="px-6 py-4">{{date("Y-m-d H:i:s", $job->created_at)}}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('jobs.cancel', $job->id) }}">
                                        @csrf
                                        <div>
                                            <x-danger-button class="ms-3">{{ __('Stop The Process') }}</x-danger-button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">#Process ID</th>
                                    <th scope="col" class="px-6 py-3">User Name</th>
                                    <th scope="col" class="px-6 py-3">User Email</th>
                                    <th scope="col" class="px-6 py-3">Failed At</th>
                                    <th scope="col" class="px-6 py-3">Process</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $jobsFailCount = 0; @endphp
                            @foreach ($jobsFailList as $jobsFail) @php $jobsFailCount++ @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">#{{$jobsFailCount}}</th>
                                <td class="px-6 py-4">{{$jobsFail->userName}}</td>
                                <td class="px-6 py-4">{{$jobsFail->email}}</td>
                                <td class="px-6 py-4">{{$jobsFail->failed_at}}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('jobs.retry', $jobsFail->id) }}">
                                        @csrf
                                        <div>
                                            <x-primary-button class="ms-3">{{ __('Retry The Process') }}</x-primary-button>
                                        </div>
                                    </form><br>
                                    <form method="POST" action="{{ route('jobs.delete', $jobsFail->id) }}">
                                        @csrf
                                        <div>
                                            <x-danger-button class="ms-3">{{ __('Delete The Process') }}</x-danger-button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">#Process ID</th>
                                    <th scope="col" class="px-6 py-3">User Name</th>
                                    <th scope="col" class="px-6 py-3">User Email</th>
                                    <th scope="col" class="px-6 py-3">Processed At</th>
                                    <th scope="col" class="px-6 py-3">Process</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $jobsSuccessCount = 0; @endphp
                            @foreach ($jobsSuccessList as $jobsSuccess) @php $jobsSuccessCount++ @endphp
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">#{{$jobsSuccessCount}}</th>
                                <td class="px-6 py-4">{{$jobsSuccess->userName}}</td>
                                <td class="px-6 py-4">{{$jobsSuccess->email}}</td>
                                <td class="px-6 py-4">{{$jobsSuccess->processed_at}}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('jobs.restart', $jobsSuccess->id) }}">
                                        @csrf
                                        <div>
                                            <x-primary-button class="ms-3">{{ __('Restart The Process') }}</x-primary-button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
