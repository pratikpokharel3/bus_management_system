<x-app-layout>
    <x-card>
        <div class="flex items-center gap-x-3">
            <x-go-back href="{{ route('admin.bus_departure.index') }}"></x-go-back>
            <x-page-header>Bus Departure Information</x-page-header>
        </div>

        <div class="mt-2 grid grid-cols-3 gap-y-5">
            <div class="flex flex-col">
                <span class="font-semibold">Bus Name</span>
                @isset($bus_departure->bus)
                    {{ $bus_departure->bus->bus_name }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Source-Destination</span>
                @isset($bus_departure->bus_route)
                    {{ $bus_departure->bus_route->source_location->district }} -
                    {{ $bus_departure->bus_route->destination_location->district }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Number of Tickets Booked</span>
                {{ $bus_departure->total_tickets ?? '0' }} out of
                @isset($bus_departure->bus)
                    {{ $bus_departure->bus->total_seats }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Departure DateTime</span>
                {{ \Carbon\Carbon::parse($bus_departure->departure_datetime)->format('jS, M Y \a\t h:i A') }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bus Status</span>
                {{ ucwords(str_replace('_', ' ', $bus_departure->departure_status)) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Added By</span>
                @isset($bus_departure->user)
                    {{ $bus_departure->user->name }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Created At</span>
                {{ \Carbon\Carbon::parse($bus_departure->created_at)->format('jS, M Y \a\t h:i A') }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Updated At</span>
                {{ \Carbon\Carbon::parse($bus_departure->updated_at)->format('jS, M Y \a\t h:i A') }}
            </div>
        </div>

        <div id="root"></div>

        <script type="text/babel">
            function MyApp() {
                const style = { width: '24%' }

                const seatsBookedList = "<?php echo $bus_departure->seats_booked; ?>".split(",")
                const seatPlanningList = [<?php echo json_encode($seat_planning); ?>][0]
                
                return <>
                    <div className="mt-12 border-t pt-8">
                        <div className="text-center">
                            <div className="text-xl font-bold">Bus Seat Planning</div>
                            <div className="mt-1">Select Seats Below for Booking</div>
                        </div>
                    
                        <div className="mt-8 flex justify-center items-center gap-x-3">
                            <div className="h-8 w-8 bg-green-600"></div>
                            <div>Already Booked</div>
                        </div>

                        <div className="mx-auto mt-10 w-1/2 border py-5">
                            <div className="border-b" style={style}></div>
                            <div className="mt-5 pl-4">Bus Door</div>
                            <div className="mt-5 border-b" style={style}></div>
                        
                            <div className="mx-auto mt-8 px-10">
                                {seatPlanningList.map(seat => (
                                    <div className="mt-5 flex justify-between gap-x-5" key={seat}>
                                        <div
                                            className={`${seatsBookedList.includes(seat[0]) ? "bg-green-600 text-white" : ""} flex w-[16%] items-center justify-center border py-3 text-center`.trimStart()}>
                                            {seat[0]}
                                        </div>

                                        <div
                                            className={`${seatsBookedList.includes(seat[1]) ? "bg-green-600 text-white" : ""} flex w-[16%] items-center justify-center border py-3 text-center`.trimStart()}>
                                            {seat[1]}
                                        </div>

                                        <div
                                            className={`${seatsBookedList.includes(seat[2]) ? "bg-green-600 text-white" : ""} flex w-[16%] items-center justify-center border py-3 text-center`.trimStart()}>
                                            {seat[2]}
                                        </div>

                                        <div
                                            className={`${seatsBookedList.includes(seat[3]) ? "bg-green-600 text-white" : ""} flex w-[16%] items-center justify-center border py-3 text-center`.trimStart()}>
                                            {seat[3]}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </>;
            }

            const container = document.getElementById('root');
            const root = ReactDOM.createRoot(container);
            root.render(<MyApp />);
        </script>
    </x-card>

    <script src="{{ asset('react.js') }}"></script>
    <script src="{{ asset('react-dom.js') }}"></script>
    <script src="{{ asset('babel.js') }}"></script>
</x-app-layout>
