<h1>Add a word</h1>
<form ng-submit="wordSubmit()" novalidate remote-validate>
    
    <span class="validation-error" ng:show="Article.$serverError.user.$invalid">
                    {{Article.$serverError.user.message}}
    </span>
    
        
    <div class="form-group">
        <label for="user">Language</label>
        <select type="text" class="form-control" name="language" ng-model="language">
            <option ng-repeat="language in availableLanguages" value="{{language.id}}">{{language.name}}</option>
        </select>
    </div>
    <errors-for field="language"></errors-for>
    
    
    <div class="form-group">
        <label for="user">Word</label>
        <input type="text" class="form-control" name="word" ng-model="word" ng-change="updateSyllables()">
    </div>
    <errors-for field="word"></errors-for>
    
    <div class="form-group big">
        <span ng-repeat="syllable in syllables">
            <span>{{syllable.syllable}}</span>
            <button ng-if="!$last" class="btn btn-default">+</button>
        </span>
    </div>

    
    <input type="submit" class="btn btn-primary btn-default" value="Add" />
</form>