@php $editing = isset($courier) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama"/>
        <x-inputs.text
            name="name"
            :value="old('name', ($editing ? $courier->name : ''))"
            maxlength="255"
            placeholder="Nama"
            required
        ></x-inputs.text>
    </x-inputs.group>       

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Email"/>
        <x-inputs.text
            name="email"
            :value="old('email', ($editing ? $courier->email : ''))"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nomor Telepon"/>
        <x-inputs.text
            name="phone"
            :value="old('phone', ($editing ? $courier->phone : ''))"
            maxlength="255"
            placeholder="Nomor Telepon"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Level"/>
        <x-inputs.select
            name="level"
            :value="old('level', ($editing ? $courier->level : ''))"
            required
        >
            <option value="" disabled {{ old('level', ($editing ? $courier->level : '')) === '' ? 'selected' : '' }}>
                Pilih Level
            </option>
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ old('level', ($editing ? $courier->level : '')) == $i ? 'selected' : '' }}>
                    Level {{ $i }}
                </option>
            @endfor
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Alamat"/>
        <x-inputs.text
            name="address"
            :value="old('address', ($editing ? $courier->address : ''))"
            maxlength="255"
            placeholder="Alamat"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
