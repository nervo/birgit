Birgit
======

[[Project]]
     |
     |
 (Project)-----------+-----------------------+--------------------------+
                     |                       |                          |
            [[ProjectReference]] [[ProjectReferenceCreate]] [[ProjectReferenceDelete]]
                     |                       |
                     |                       |
             (ProjectReference)  (ProjectReferenceEnvironments)
               |                                          |  
               |                                          |
   +-----------+--------------+                           +----------------------------+
   |           |              |                           |                            |
[[Host]] [[HostCreate]] [[HostDelete]]       [[ProjectReferenceRevision]] [[ProjectReferenceRevisionCreate]]
