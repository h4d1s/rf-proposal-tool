<div class="mb-5">
  <x-form.select id="state" name="state" label="{{ __('State') }}">
    <x-slot:options>
      @foreach (\App\Models\ProposalState::all() as $state)
        <option value="{{ $state->id }}" @selected(old('state', $proposal->state->id) ===  $state->id)>
          {{ ucfirst($state->name) }}
        </option>
      @endforeach
    </x-slot>
  </x-form.select> 
</div>

<div class="mb-5">
  <h5>Action log</h5>

  @php
    $team = $proposal->project->projectable->team;
    $activities = $team->activities()->get();
  @endphp

  <div class="table-responsive scrollable">
    <table class="table">
      <thead>
        <tr>
        <th scope="col">Time</th>
        <th scope="col">Who</th>
        <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($activities as $activity)
        <tr>
          <td>{{ $activity->created_at->diffForHumans() }}</td>
          <td>
            @if($activity->causer->getMorphClass() === "App\Models\Client")
              {{ $activity->causer->full_name }}
            @else
              {{ $activity->causer->name }}
            @endif
          </td>
          <td>{{ $activity->activity_type->name }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div>
  <h5>Email to client</h5>
  <label for="state" class="form-label text-label">Template</label>

  <div id="proposal-select-email-template">
    <v-select label="name" :filterable="false" :options="options"
      v-model="selected" @search="onSearch">
      <template #no-options="{ search, searching }">
        <template v-if="searching">
          No results found for <em>@{{ search }}</em>.
        </template>
        <template v-else>{{ __('type to search email template...') }}</template>
      </template>
      <template #option="option">
        @{{ option.name }}
      </template>
      <template #selected-option="option">
        <div class="selected">
          @{{ option.name }}
        </div>
      </template>
    </v-select>
    <input type="hidden" name="email_template" v-if="selected" :value="selected.id" />
  </div>
</div>

