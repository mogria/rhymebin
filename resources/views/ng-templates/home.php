<div class="jumbotron">
    <h1>RhymeBin</h1>
    <p>RhymeBin is a rhyme platform</p>
    <p><a class="btn btn-primary btn-lg" href="#">Learn more</a></p>

    <form action="#" ng-submit="searchSubmit()">
        <div class="row">
            <div class="col-xs-12 col-md-7 form-group">
                <input type="text" class="form-control" name="search" placeholder="Search for a rhyme ... " ng-model="search" />
            </div>
            <div class="col-xs-12 col-md-3 form-group">
                <select name="language" class="form-control" >
                   <option>All languages</option>
                </select>
            </div>
            <div class="col-xs-2 col-xs-offset-10 col-md-offset-0 col-md-2 form-group">
                <input type="submit" class="btn btn-default btn-primary" value="search" />
            </div>
        </div>
    </form>
</div>
