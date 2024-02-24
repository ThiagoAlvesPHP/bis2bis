<div class="row">
    <div class="col">
        <h1><?= $this->title; ?></h1>

        <?php if (!empty($_SESSION['alert'])) : ?>
            <div class="alert alert-<?= $_SESSION['alert']['class'] ?? ""; ?> <?= $_SESSION['alert']['status'] ? "logado" : ""; ?> d-flex align-items-center" role="alert">
                <div>
                    <?= $_SESSION['alert']['message'] ?? ""; ?>
                </div>
            </div>
        <?php endif; ?>
        <h3>Registro</h3>
        <form action="<?= BASE ?>admin/posts/action<?= $find ? "?id=" . $find["id"] : ""; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Título *</label>
                <input type="text" value="<?= $find ? $find["title"] : ""; ?>" class="form-control" id="title" name="title" oninput="converterParaSlug()">
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug *</label>
                <input type="text" value="<?= $find ? $find["slug"] : ""; ?>" class="form-control" id="slug" name="slug">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Imagem * <small>(jpg, png)</small></label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Conteudo *</label>
                <textarea name="text" id="text" cols="30" rows="10"><?= $find ? $find["text"] : ""; ?></textarea>
            </div>

            <div class="d-grid gap-2 d-md-block">
                <button class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col">
        <h3>Lista</h3>
        <div class="table table-responsive">
            <table class="table table-striped table-hover" id="list">
                <thead>
                    <tr>
                        <th>Ação</th>
                        <th>Título</th>
                        <th>Slug</th>
                        <th>Imagem</th>
                        <th>Autor</th>
                        <th>Status</th>
                        <th>Registrado em</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    //EDITOR
    CKEDITOR.replace('text');

    function converterParaSlug() {
        const title = document.getElementById('title').value;
        const slugInput = document.getElementById('slug');
        // Lógica para converter texto em slug
        const slug = title.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]+/g, '');
        // Exibir o slug no campo de input
        slugInput.value = slug;
    }

    $(document).ready(function() {
        $('#list').DataTable({
            "processing": true,
            "serverSide": true,
            "language": {
                "lengthMenu": "_MENU_ registros por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(Filtrado de _MAX_ registros no total)",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
            },
            "order": [
                [1, "desc"]
            ],
            "ajax": {
                "url": BASE + "admin/posts/ajax",
                "type": "POST"
            }
        });
    });
</script>