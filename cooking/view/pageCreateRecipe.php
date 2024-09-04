<div class="createRecipe">
    <form method="post"  enctype="multipart/form-data">
        <table>
            <tr><th>Название</th>
                <td><input type="text" name="title"></td></tr>
            <tr><th>Ингредиенты</th>
                <td>{{composition}}</td></tr>
            <tr><th>Приготовление</th><br>
                <td><textarea rows="5" cols="35" 
                    name="steps"></textarea></td></tr>
            <tr><th>Картинка</th>
            <td><input type="file" name="picture"><br>
            <p style="font-size:15px;">Размер файла не более 100 кб</p></td></tr>
        </table>
        <input type="submit">
    </form>
</div>