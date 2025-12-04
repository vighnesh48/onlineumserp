<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Images</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css'>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(238, 244, 255);
        }

        .gallery-container {
            max-width: 75%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .image-tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease-in-out;
        }

        .image-tile:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .image-tile img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        .delete-btn {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="gallery-container mt-5">
        <h2 class="text-center mb-4">Event Image Gallery</h2>
        <div class="text-end">
            <a href="<?= base_url($currentModule . '/upload_event_photos/' . ($this->uri->segment(3))) ?>" class="btn btn-primary">Add Image</a>
            <a href="<?= base_url($currentModule . '/') ?>" class="btn btn-primary">Back</a>
        </div>
        <div class="row">
            <?php if (!empty($event_images)): ?>
                <?php foreach ($event_images as $image): ?>
                    <?php
                    $bucket_key = 'uploads/events/' . $image['file_name'];
                    $imageData = $this->awssdk->getImageData($bucket_key); // Ensure it returns a valid image URL


                    ?>
                    <div class="col-md-3 image-tile"> <a href="<?= htmlspecialchars($imageData) ?>" class="glightbox" data-glightbox="type: image">

                            <img src="<?= htmlspecialchars($imageData) ?>" alt="Image">
                        </a>
                        <form action="<?= base_url($currentModule . "/delete_event_image/" . base64_encode($image['id'])) ?>" method="POST">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this image?')" class="btn btn-danger mt-2 delete-btn">Delete</button>
                        </form>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No images found.</p>
            <?php endif; ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        const lightbox = GLightbox({
            touchNavigation: true,
            loop: true,
            width: "90vw",
            height: "90vh"
        });
    </script>
</body>

</html>