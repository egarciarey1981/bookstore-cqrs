Para agrupar las implementaciones (InMemory, Persona, etc.) relacionadas más cerca, es preferible:

Catalog/
    Infrastructure/
        Persistence/
            InMemory/ **
                Command/ **
                    InMemoryBookCommandRepository.php

a esta otra

Catalog/
    Infrastructure/
        Persistence/
            Command/ **
                InMemory/ **
                    InMemoryBookCommandRepository.php